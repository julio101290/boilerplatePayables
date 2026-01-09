<?php

$reportPayable["title"] = "Verkaufsbericht";
$reportPayable["subtitle"] = "Verkäufe nach Firma, Filiale, Produkt";
$reportPayable["companie"] = "Firma";
$reportPayable["allCompanies"] = "Alle Firmen";
$reportPayable["branchOffice"] = "Filiale";
$reportPayable["allBranchOffice"] = "Alle Filialen";
$reportPayable["products"] = "Produkte";
$reportPayable["allProducts"] = "Alle Produkte";

$reportPayable["custumer"] = "Kunde";
$reportPayable["allCustumes"] = "Alle Kunden";
$reportPayable["load"] = "Laden";
$reportPayable["field"]["row"] = "#";
$reportPayable["field"]["companie"] = "Firma";
$reportPayable["field"]["branchOffice"] = "Filiale";
$reportPayable["field"]["folio"] = "Folio"; // Como en inglés, se puede dejar "Folio" o usar "Referenznummer", "Rechnungsnummer" o "Belegnummer" según el contexto.

$reportPayable["field"]["date"] = "Datum";
$reportPayable["field"]["nameCustumer"] = "Kundenname";
$reportPayable["field"]["lastNameCustumer"] = "Kunden Nachname";
$reportPayable["field"]["socialReasonCustumer"] = "Firmenname des Kunden"; // o "Gesellschaftsname des Kunden"
$reportPayable["field"]["idProduct"] = "Produkt-ID";

$reportPayable["field"]["codeProduct"] = "Produktcode";
$reportPayable["field"]["description"] = "Beschreibung";
$reportPayable["field"]["amount"] = "Menge";
$reportPayable["field"]["price"] = "Preis";
$reportPayable["field"]["total"] = "Gesamtbetrag";

$reportPayable["field"]["tax"] = "Steuer";
$reportPayable["field"]["granTotal"] = "Nettobetrag"; // o "Bruttobetrag" si incluye impuestos.

return $reportPayable;
