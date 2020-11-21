
<h2>Contact</h2>

<div class="container">

    <p id="required-legend">Les champs marqués d'une étoile sont requis</p>

    <form class="form">

        <div class="row">
            <div id="id-container" class="col-12 col-lg-6">
                <div class="custom-input">
                    <input id="id" name="id" type="text" placeholder="" required />
                    <label for="id">Identifiant</label>
                </div>
            </div>

            <div id="email-container" class="col-12 col-lg-6">
                <div class="custom-input">
                    <input id="email" name="email" type="email" placeholder="" required />
                    <label for="email">Email</label>
                </div>
            </div>
        </div>

        <div id="objet-container">
            <div class="custom-input">
                <input id="objet" name="objet" type="text" placeholder="" required />
                <label for="objet">Objet</label>
            </div>
        </div>

        <div id="message-container">
            <div class="custom-input">
                <textarea id="message" name="message" placeholder="" required ></textarea>
                <label for="message">Message</label>
            </div>
        </div>

        <div id="submit-container" class="text-center text-lg-right">
            <input id="submit" name="submit" type="submit" placeholder="" required />
        </div>

    </form>

</div>