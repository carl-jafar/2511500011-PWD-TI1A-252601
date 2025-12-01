<?php 
function bersihkan($str) 
{ 
return htmlspecialchars(trim($str)); 
} 
function tidakKosong($str) 
{ 
return strlen(trim($str)) > 0; 
} 
function formattanggal($tgl)
{
    return date("d m y", strtotime($tgl))
}
function tampilkanbiodata($conf, $arr)
{
    $html = "";
    foreach ($conf as $k => $v) {
        $label = $v["label"];
        $nilai = bersihkan($arr[$k]);
        $suffix = $v["$suffix"];

        $html = "<p><strong>{label}</strong> {nilai}{$suffix}</p>"
    }
}