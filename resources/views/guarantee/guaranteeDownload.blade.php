<div style="text-align: center">
    <strong>Garantinis Talonas</strong>
    <br>
    <strong>"UAB Remontas"</strong>
    <br>
    <hr>
</div>

<small>{{'Kompiuterio gamintojas: ' . $guaranteeForm->computer_brand}}</small>
<br>
<small>{{'Kompiuterio Modelis: ' . $guaranteeForm->computer_model}}</small>
<br>
<small>{{'Saskaitos numeris: ' . $guaranteeForm->saskaitos_nr}}</small>
<br>
<small>{{'Pateikimo data: ' . $guaranteeForm->created_at}}</small>
<br>
<small>{{'Sutaisymo data: ' . $guaranteeForm->updated_at}}</small>
<br>
<small>{{'Garantijos galiojimo laikas: ' . $guaranteeForm->updated_at->addDays(90)}}</small>