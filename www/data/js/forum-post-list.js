/**
 * @function forum
 * @param {jQuery} table
 * @param {{
 *  id: number,
 *  title: string,
 *  author: {id: number, name: string},
 *  message_count: number,
 *  created_at: string,
 *  last_activity: string
 * }[]} posts
 */
function forumtalk(table, posts) {
	table.empty();
	for (let talk of posts) {
		table.append(
				`<tr>
					<td><a href="/forum/talk/${talk.id}">${Utils.misc.escape(talk.title)}</a></td>
					<td><a href="/user/profile/${talk.author.id}">${Utils.misc.escape(talk.author.name)}</a></td>
					<td>${Utils.misc.escape(talk.message_count)}</td>
					<td>${Utils.date.format(talk.created_at)}</td>
					<td>${Utils.date.format(talk.last_activity)}</td>
				</tr>`
		);
	}
}

/**
 * @param {jQuery} table
 * @param {{
 *  id: number,
 *  title: string,
 *  entity: {id: number, name: string},
 *  rate: number,
 *  author: {id: number, name: string},
 *  message_count: number,
 *  created_at: string,
 *  last_activity: string
 * }[]} posts
 */
function forumrate(table, posts) {
	table.empty();
	for (let rate of posts) {
		table.append(
				`<tr>
					<td><a href="/forum/rate/${rate.id}">${Utils.misc.escape(rate.title)}</a></td>
					<td><a href="/wiki/page/entity/${rate.entity.id}">${Utils.misc.escape(rate.entity.name)}</a></td>
					<td>${Utils.misc.escape(rate.rate)}</td>
					<td><a href="/user/profile/${rate.author.id}">${Utils.misc.escape(rate.author.name)}</a></td>
					<td>${Utils.misc.escape(rate.message_count)}</td>
					<td>${Utils.date.format(rate.created_at)}</td>
					<td>${Utils.date.format(rate.last_activity)}</td>
				</tr>`
		);
	}
}

/**
 * @param {jQuery} table
 * @param {{
 *  id: number,
 *  title: string,
 *  hero: {id: number, name: string},
 *  level: {id: number, name: string},
 *  author: {id: number, name: string},
 *  message_count: number,
 *  created_at: string,
 *  last_activity: string
 * }[]} posts
 */
function forumstrat(table, posts) {
	table.empty();
	for (let strat of posts) {
		table.append(
				`<tr>
					<td><a href="/forum/strat/${strat.id}">${Utils.misc.escape(strat.title)}</a></td>
					<td><a href="/wiki/page/level/${strat.level.id}">${Utils.misc.escape(strat.level.name)}</a></td>
					<td><a href="/wiki/page/entity/${strat.hero.id}">${Utils.misc.escape(strat.hero.name)}</a></td>
					<td><a href="/user/profile/${strat.author.id}">${Utils.misc.escape(strat.author.name)}</a></td>
					<td>${Utils.misc.escape(strat.message_count)}</td>
					<td>${Utils.date.format(strat.created_at)}</td>
					<td>${Utils.date.format(strat.last_activity)}</td>
				</tr>`
		);
	}
}
