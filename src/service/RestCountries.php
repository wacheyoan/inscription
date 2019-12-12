<?php

/*Je récupère le nom du pays et le code du pays
J'utilise une autre api pour lister tous les pays dans mon select, les noms des pays ne sont pas
les mêmes
C'est pourquoi j'utilise le code du pays pour comparer
*/
foreach ($test2['results'] as $result){
    foreach ($result['address_components'] as $addresses){
        if($addresses['types'][0] == 'country' && $addresses['types'][1] != 'natural_feature'){
            $countryName = $addresses['long_name'];
            $countryCode = $addresses['short_name'];
        }else{
            $countryName = null;
            $countryCode = null;
        }
    }
}

//Je récupère tous les pays recensés dans cette api et je récupère leur nom et code
$everyCountries = json_decode(file_get_contents('https://restcountries.eu/rest/v2/all'),
    true);
foreach ($everyCountries as $country) {
    $tab[] = [
        [
            'countryName' => $country['name'],
            'countryCode' => $country['alpha2Code']
        ]
    ];
}