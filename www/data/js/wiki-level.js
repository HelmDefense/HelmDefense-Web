const map = $("#map");
for (let y = 0; y < level.map.length; y++) {
	let row = $(document.createElement("div"));
	row.addClass("map-row");
	for (let x = 0; x < level.map[y].length; x++)
		row.append(`<div class="map-tile"><img src="/data/img/wiki/level/maptiles/${level.map[y][x]}.png" alt="" /></div>`);
	map.append(row);
}
const onResize = [];
/**
 * @param {string} item
 * @param {{x: number, y: number, [hp]: number}[]} elements
 * @param {function({x: number, y: number, [hp]: number}): string} tooltip
 */
function mapItems(item, elements, tooltip) {
	for (let element of elements) {
		let s = $(document.createElement("div"));
		s.addClass(`map-${item} map-element`).attr("data-pos", `${element.x};${element.y}`);
		Utils.tooltip.add(s, tooltip(element));
		onResize.push(size => s.css("top", `${size * element.y}px`).css("left", `${size * element.x}px`));
		map.append(s);
	}
	$(`.map-${item}-legend`).on("mouseenter", e => {
		$(`.map-${item}[data-pos="${e.currentTarget.dataset.pos}"]`).addClass("hovered").tooltip("show");
	}).on("mouseleave", e => {
		$(`.map-${item}[data-pos="${e.currentTarget.dataset.pos}"]`).removeClass("hovered").tooltip("hide");
	});
}
mapItems("spawn", level.spawns, spawn => `Spawn (${spawn.x} ; ${spawn.y})`);
mapItems("door", level.doors, door => `Porte (${door.x} ; ${door.y}) : ${door.hp} PV`);
Utils.misc.jWindow.on("resize load", () => {
	let size = $(".map-tile").first().width();
	for (let handler of onResize)
		handler(size);
});

const entitiesCarousel = $("#entities .carousel-inner");
Utils.pagination.show({
	container: $("#waves"),
	pages: level.waves.map(wave => wave.name),
	callback: page => {
		let wave = level.waves.filter(wave => wave.name === page.name)[0];
		$("#wave-reward").text(wave.reward);
		entitiesCarousel.empty();
		let items = "<div class='carousel-item'><div class='d-flex'>";
		let i = 0;
		let entities = new Set();
		let waveEntities = Object.entries(wave.entities).sort((e1, e2) => e1[0] - e2[0]);
		for (let [tick, entity] of waveEntities) {
			items += `<div class="wave-entity" data-wave-entity="${entity}"><img src="" alt="${entity}" /><p class="entity-name font-weight-bold">${entity}</p><p>Apparition : ${tick}</p></div>`;
			entities.add(entity);
			i++;
			if (i % 4 === 0 && i !== waveEntities.length)
				items += "</div></div><div class='carousel-item'><div class='d-flex'>";
		}
		entitiesCarousel.append(items + "</div></div>");
		entitiesCarousel.children().first().addClass("active");

		for (let entity of entities) {
			Utils.ajax.getWithCache({
				url: `v1/entities/${entity}`,
				callback: ent => {
					let item = $(`.wave-entity[data-wave-entity=${entity}]`);
					item.children("img").attr("src", ent.img).attr("alt", ent.name);
					item.children(".entity-name").text(ent.name);
					return true;
				},
				toApi: true
			});
		}
		return true;
	},
	triggerOnCreation: true,
	ignoreWhenSelected: true
});
