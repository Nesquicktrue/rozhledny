<x-app-layout>
    <x-slot name="header">
        <script type="text/javascript" src="https://api.mapy.cz/loader.js"></script>
        <script type="text/javascript">
            Loader.load();
        </script>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            MAPA
        </h2>
    </x-slot>
    <div class="flex-row flex">
        <div id="m" style="width:100%; height:600px;"></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script type="text/javascript">
        const allTowers = {!! json_encode($allTowers->toArray()) !!} // načítám allTowers z PHP
        const myTowers = {!! json_encode($myTowers->toArray()) !!} // načítám myTowers z PHP

        let dropImgRed = "https://api.mapy.cz/img/api/marker/drop-red.png";
        let dropImgBlue = "https://api.mapy.cz/img/api/marker/drop-blue.png";

        let m = new SMap(JAK.gel("m"));
        m.addControl(new SMap.Control.Sync()); /* Aby mapa reagovala na změnu velikosti průhledu */
        m.addDefaultLayer(SMap.DEF_BASE).enable(); /* Turistický podklad */
        m.addDefaultControls();

        let markerAllTowers = [];
        let souradnice = [];

        // Vyrob červené značky pro všechny rozhledny 
        allTowers.forEach((tower) => {
            /* Vyrobit značky */
            let c = SMap.Coords.fromWGS84(tower.x, tower.y); /* Souřadnice značky */

            let options = {
                url: dropImgRed,
                title: tower.name,
                anchor: {
                    left: 10,
                    bottom: 1
                } /* Ukotvení značky za bod uprostřed dole */
            }

            let card = new SMap.Card();
            card.getHeader().innerHTML = "<strong>" + tower.name + "</strong>";
            card.getBody().innerHTML = '<i>Zobrazit rohlednu na:</i><br><a href="http://' + tower.url +
                '" target="_blank">Rozhlednovým rájem.cz</a>' +
                '<br><a href="https://mapy.cz/turisticka?q=rozhledna ' + tower.name +
                '" target="_blank">Mapy.cz</a><br><hr><br>' +
                '<form class="forma">' +
                '<input type="hidden" id="towerIDinput" name="towerid" value="' + tower.id + '"></input>' +
                '<label>Den návštěvy:</label>' +
                '<div class="flex">' +
                '<input class="flex-auto m-1" type="date" id="visitedAtInput" name="visitedAt"></input>' +
                '<button class="oznac flex-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-1" type="submit">Označ jako navštívenou</button>' +
                '</form></div>';

            let znacka = new SMap.Marker(c, null, options);
            znacka.decorate(SMap.Marker.Feature.Card, card);


            souradnice.push(c);
            markerAllTowers.push(znacka);
        })

        // Vyrob značky pro navštívené rozhledny
        let markerMyTowers = [];
        let souradniceMyTowers = [];

/*         myTowers = [{
            name: 'Moje první',
            x: 16.602806,
            y: 50.11524,
            url: 'test'
        }] */

        myTowers.forEach((tower) => {
            /* Vyrobit značky */
            let c = SMap.Coords.fromWGS84(tower.x, tower.y); /* Souřadnice značky */

            let options = {
                url: dropImgBlue,
                title: tower.name,
                anchor: {
                    left: 10,
                    bottom: 1
                } /* Ukotvení značky za bod uprostřed dole */
            }

            let card = new SMap.Card();
            card.getHeader().innerHTML = "<strong>" + tower.name + "</strong>";
            card.getBody().innerHTML = '<strong>Navštíveno dne:' + tower.date + '</strong><br>' +
                '<i>Zobrazit rohlednu na:</i><br><a href="http://' + tower.url +
                '" target="_blank">Rozhlednovým rájem.cz</a>' +
                '<br><a href="https://mapy.cz/turisticka?q=rozhledna ' + tower.name +
                '" target="_blank">Mapy.cz</a>';


            let znacka = new SMap.Marker(c, null, options);
            znacka.decorate(SMap.Marker.Feature.Card, card);

            souradniceMyTowers.push(c);
            markerMyTowers.push(znacka);
        })

        let layerAllTowers = new SMap.Layer.Marker(); /* Vrstva se všemy značkami */
        let layerMyTowers = new SMap.Layer.Marker(); /* Vrstva s mojemi značkami */
        m.addLayer(layerAllTowers); /* Přidat je do mapy */
        m.addLayer(layerMyTowers); /* Přidat je do mapy */
        layerAllTowers.enable(); /* A povolit */
        layerMyTowers.enable(); /* A povolit */

        for (let i = 0; i < markerAllTowers.length; i++) {
            layerAllTowers.addMarker(markerAllTowers[i]);
        }
        for (let i = 0; i < markerMyTowers.length; i++) {
            layerMyTowers.addMarker(markerMyTowers[i]);
        }

        let cz = m.computeCenterZoom(souradnice); /* Spočítat pozici mapy tak, aby značky byly vidět */
        m.setCenterZoom(cz[0], cz[1]);

        let testTower = {
            name: 'Borůvková hora',
            x: 16.902669,
            y: 50.390713,
            date: '2022-08-26',
            url: 'www.rozhlednovymrajem.cz/boruvkova-hora'
        }

        function makeBlue(newTower) {
            let coords = SMap.Coords.fromWGS84(newTower.x, newTower.y);
            let options = {
                url: dropImgBlue,
                title: newTower.name,
                anchor: {
                    left: 10,
                    bottom: 1
                } /* Ukotvení značky za bod uprostřed dole */
            }

            let card = new SMap.Card();
            card.getHeader().innerHTML = "<strong>" + newTower.name + "</strong>";
            card.getBody().innerHTML = '<strong>Navštíveno dne:' + newTower.date + '</strong><br>' +
                '<i>Zobrazit rohlednu na:</i><br><a href="http://' + newTower.url +
                '" target="_blank">Rozhlednovým rájem.cz</a>' +
                '<br><a href="https://mapy.cz/turisticka?q=rozhledna ' + newTower.name +
                '" target="_blank">Mapy.cz</a>';
            let newZnacka = new SMap.Marker(coords, null, options);
            newZnacka.decorate(SMap.Marker.Feature.Card, card);
            layerMyTowers.addMarker(newZnacka);
            newZnacka.click()
        }


        m.getSignals().addListener(null, "marker-click", (event) => {
            setTimeout(() => {
                $(".forma").on("submit", (e) => {
                    e.preventDefault();
                    let towerID = $('#towerIDinput').val();
                    let visitedAt = $('#visitedAtInput').val();
                    $.ajax({
                        type: 'POST',
                        url: '/mapa/add',
                        data: {
                            "towerID": towerID,
                            "visitedAt": visitedAt,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            let result = allTowers.find(
                            obj => { //najdi objekt rozhledny v allTowers
                                return obj.id == towerID
                            })
                            makeBlue(result) // a udělej ho modrým
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                })

            }, 500);
        })
    </script>
    </body>
</x-app-layout>
