<?php

namespace common\models;

class LocationHelper
{
    // Lista de países da União Europeia (código ISO => Nome do país)
    public static function getCountries()
    {
        return [
            'PT' => 'Portugal',
            'ES' => 'Espanha',
            'FR' => 'França',
            'DE' => 'Alemanha',
            'IT' => 'Itália',
            'NL' => 'Países Baixos',
            'BE' => 'Bélgica',
            'PL' => 'Polônia',
            'SE' => 'Suécia',
            'AT' => 'Áustria',
            'FI' => 'Finlândia',
            'DK' => 'Dinamarca',
            'IE' => 'Irlanda',
            'CZ' => 'República Tcheca',
            'HU' => 'Hungria',
            'RO' => 'Romênia',
            'BG' => 'Bulgária',
            'GR' => 'Grécia',
            'HR' => 'Croácia',
            'SK' => 'Eslováquia',
            'SI' => 'Eslovênia',
            'EE' => 'Estônia',
            'LV' => 'Letônia',
            'LT' => 'Lituânia',
            'CY' => 'Chipre',
            'LU' => 'Luxemburgo',
            'MT' => 'Malta',
        ];
    }

    // Lista de cidades por país
    public static function getCitiesByCountry($countryCode)
    {
        $cities = [
            'PT' => ['Lisboa', 'Porto', 'Coimbra', 'Faro', 'Braga'],
            'ES' => ['Madrid', 'Barcelona', 'Valência', 'Sevilha', 'Bilbao'],
            'FR' => ['Paris', 'Lyon', 'Marseille', 'Nice', 'Toulouse'],
            'DE' => ['Berlim', 'Munique', 'Hamburgo', 'Colônia', 'Frankfurt'],
            'IT' => ['Roma', 'Milão', 'Nápoles', 'Florença', 'Veneza'],
            'NL' => ['Amsterdã', 'Roterdã', 'Haia', 'Utrecht', 'Eindhoven'],
            'BE' => ['Bruxelas', 'Antuérpia', 'Gante', 'Bruges', 'Liège'],
            'PL' => ['Varsóvia', 'Cracóvia', 'Gdańsk', 'Wrocław', 'Poznań'],
            'SE' => ['Estocolmo', 'Gothenburg', 'Malmö', 'Uppsala', 'Västerås'],
            'AT' => ['Viena', 'Salzburgo', 'Innsbruck', 'Graz', 'Linz'],
            'FI' => ['Helsinque', 'Espoo', 'Tampere', 'Vantaa', 'Oulu'],
            'DK' => ['Copenhague', 'Aarhus', 'Odense', 'Aalborg', 'Esbjerg'],
            'IE' => ['Dublin', 'Cork', 'Limerick', 'Galway', 'Waterford'],
            'CZ' => ['Praga', 'Brno', 'Ostrava', 'Pilsen', 'Liberec'],
            'HU' => ['Budapeste', 'Debrecen', 'Szeged', 'Miskolc', 'Pécs'],
            'RO' => ['Bucareste', 'Cluj-Napoca', 'Timișoara', 'Iași', 'Constança'],
            'BG' => ['Sófia', 'Plovdiv', 'Varna', 'Burgas', 'Ruse'],
            'GR' => ['Atenas', 'Salônica', 'Patras', 'Heraclião', 'Larissa'],
            'HR' => ['Zagreb', 'Split', 'Rijeka', 'Osijek', 'Zadar'],
            'SK' => ['Bratislava', 'Košice', 'Prešov', 'Žilina', 'Nitra'],
            'SI' => ['Liubliana', 'Maribor', 'Celje', 'Kranj', 'Velenje'],
            'EE' => ['Tallinn', 'Tartu', 'Narva', 'Pärnu', 'Viljandi'],
            'LV' => ['Riga', 'Daugavpils', 'Liepāja', 'Jelgava', 'Jūrmala'],
            'LT' => ['Vilnius', 'Kaunas', 'Klaipėda', 'Šiauliai', 'Panevėžys'],
            'CY' => ['Nicósia', 'Limassol', 'Lárnaca', 'Famagusta', 'Pafos'],
            'LU' => ['Luxemburgo', 'Esch-sur-Alzette', 'Differdange', 'Dudelange', 'Ettelbruck'],
            'MT' => ['Valeta', 'Sliema', 'Birkirkara', 'Mdina', 'Qormi'],
        ];

        return $cities[$countryCode] ?? [];
    }
}
