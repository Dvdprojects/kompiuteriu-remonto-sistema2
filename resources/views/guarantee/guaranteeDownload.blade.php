<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table, th, td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 70%;
            margin: 20px auto;
        }

        .row-name {
            padding-left: 10px;
            font-size: 18px;
        }

        .row-value {
            text-align: center;
            font-size: 18px;
        }

        .first-line {
            font-weight: bold;
            text-decoration: underline;
            font-size: 12px;
        }

        .base-text {
            font-size: 12px;
            text-align: justify;
        }

        li {
            font-size: 12px;
        }
    </style>
</head>
<body>

<div style="text-align: center">
    <h2>Garantinis Talonas<br>
        "UAB Remontas"</h2>
    <hr>
</div>

<table>
    <tr>
        <td class="row-name">Kompiuterio gamintojas</td>
        <td class="row-value">{{$guaranteeForm->computer->computer_brand}}</td>
    </tr>
    <tr>
        <td class="row-name">Kompiuterio modelis</td>
        <td class="row-value">{{$guaranteeForm->computer->computer_model}}</td>
    </tr>
    <tr>
        <td class="row-name">Užsakymo numeris</td>
        <td class="row-value">{{$guaranteeForm->saskaitos_nr}}</td>
    </tr>
    <tr>
        <td class="row-name">Pateikimo data</td>
        <td class="row-value">{{$guaranteeForm->created_at}}</td>
    </tr>
    <tr>
        <td class="row-name">Sutaisymo data</td>
        <td class="row-value">{{$guaranteeForm->updated_at}}</td>
    </tr>
    <tr>
        <td class="row-name">Garantijos galiojimo laikas</td>
        <td class="row-value">{{$guaranteeForm->updated_at->addDays(90)}}</td>
    </tr>
</table>

<p class="first-line">Garantiniai įsipareigojimai</p>
<p class="base-text">Visoms prekėms suteikiama gamintojo garantija, kurios terminus ir kitas sąlygas rasite tokių prekių
    aprašymuose bei garantiniuose talonuose. Prekės gamintojo garantiniai įsipareigojimai galioja tik tuo atveju, jei
    nepažeistos prekės eksploatavimo sąlygos, kurios nurodytos garantiniame talone ir prekės naudojimo instrukcijoje.
    Norėdami išvengti nesusipratimų, prašome Jūsų atidžiai perskaityti prekės eksploatavimo instrukciją, garantinių
    įsipareigojimų ir nemokamo serviso aptarnavimo sąlygas.</p>
<p class="base-text">Pateikdami prekę garantiniam remontui, būtinai pateikite užsakymo numerį. Garantijos galiojimo metu
    garantinis remontas atliekamas nemokamai.</p>
<p class="base-text">Tuo atveju, jei nusipirkę vieną iš prekių, pastebėjote, kad ji yra nekokybiška, Jūs turite teisę
    grąžinti tokią prekę mums per prekės garantiniame talone nurodytą terminą. Tokiu atveju netinkamos kokybės prekė
    nemokamai pakeičiama į kokybišką prekę arba Jums grąžinami sumokėti pinigai.</p>
<ul>
    <li>
        Gamintojo garantija netaikoma natūraliai susidėvinčioms prekių dalims.
    </li>
</ul>
<p class="base-text">Prekes garantiniam aptarnavimui pristatykite į UAB „Remontas“ garantinio aptarnavimo punktą,
    išskyrus žemiau esančiuose skyreliuose nurodytas išimtis.</p>
<p class="base-text">Garantinio aptarnavimo teikimo metu dėl gamintojo kaltės atsiradę gedimai šalinami per šiuos
    terminus: 14-21 dienų nuo prekės perdavimo garantinį aptarnavimą atliekančiam servisui arba per 45 dienas, jei
    garantiniam remontui atlikti būtina detalė turi būti pristatyta iš užsienio. Visais atvejais garantinį aptarnavimą
    siekiama atlikti per kuo trumpesnį laiką.</p>
<p class="base-text">Pardavėjo teikiama kokybės garantija neapriboja ir nevaržo vartotojų teisių, kurias įsigijus
    netinkamos kokybės prekę ar paslaugą, jiems nustato teisės aktai.</p>
<ul>
    <li>
        Prekę būtina pristatyti tokios komplektacijos, kad ją būtų galima įjungti
    </li>
</ul>
</body>
</html>