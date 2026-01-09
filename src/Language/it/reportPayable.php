<?php

$reportPayable["title"] = "Rapporto Vendite";
$reportPayable["subtitle"] = "Vendite per Azienda, Filiale, Prodotto";
$reportPayable["companie"] = "Azienda";
$reportPayable["allCompanies"] = "Tutte le Aziende";
$reportPayable["branchOffice"] = "Filiale";
$reportPayable["allBranchOffice"] = "Tutte le Filiali";
$reportPayable["products"] = "Prodotti";
$reportPayable["allProducts"] = "Tutti i Prodotti";

$reportPayable["custumer"] = "Cliente";
$reportPayable["allCustumes"] = "Tutti i Clienti";
$reportPayable["load"] = "Carica";
$reportPayable["field"]["row"] = "#";
$reportPayable["field"]["companie"] = "Azienda";
$reportPayable["field"]["branchOffice"] = "Filiale";
$reportPayable["field"]["folio"] = "Folio"; // Come nelle traduzioni precedenti, "Folio" può rimanere invariato o si possono usare "Numero di riferimento", "Numero di fattura" o "Numero di documento" a seconda del contesto.

$reportPayable["field"]["date"] = "Data";
$reportPayable["field"]["nameCustumer"] = "Nome Cliente";
$reportPayable["field"]["lastNameCustumer"] = "Cognome Cliente";
$reportPayable["field"]["socialReasonCustumer"] = "Ragione Sociale del Cliente";
$reportPayable["field"]["idProduct"] = "ID Prodotto";

$reportPayable["field"]["codeProduct"] = "Codice Prodotto";
$reportPayable["field"]["description"] = "Descrizione";
$reportPayable["field"]["amount"] = "Quantità";
$reportPayable["field"]["price"] = "Prezzo";
$reportPayable["field"]["total"] = "Totale";

$reportPayable["field"]["tax"] = "Imposta";
$reportPayable["field"]["granTotal"] = "Totale Netto"; // o "Totale Lordo" se include le imposte.

return $reportPayable;
