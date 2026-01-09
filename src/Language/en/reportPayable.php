<?php

$reportPayable["title"] = "Sales Report";
$reportPayable["subtitle"] = "Sales by Company, Branch, Product";
$reportPayable["companie"] = "Company";
$reportPayable["allCompanies"] = "All Companies";
$reportPayable["branchOffice"] = "Branch";
$reportPayable["allBranchOffice"] = "All Branches";
$reportPayable["products"] = "Products";
$reportPayable["allProducts"] = "All Products";

$reportPayable["custumer"] = "Customer"; // Corrected spelling
$reportPayable["allCustumes"] = "All Customers"; // Corrected spelling and pluralized
$reportPayable["load"] = "Load";
$reportPayable["field"]["row"] = "#";
$reportPayable["field"]["companie"] = "Company";
$reportPayable["field"]["branchOffice"] = "Branch";
$reportPayable["field"]["folio"] = "Folio"; // Folio is often kept as is, but "Reference Number" or "Invoice Number" could also be used depending on context.

$reportPayable["field"]["date"] = "Date";
$reportPayable["field"]["nameCustumer"] = "Customer Name";
$reportPayable["field"]["lastNameCustumer"] = "Customer Last Name";
$reportPayable["field"]["socialReasonCustumer"] = "Customer Business Name"; // Or "Customer Company Name"
$reportPayable["field"]["idProduct"] = "Product ID";

$reportPayable["field"]["codeProduct"] = "Product Code";
$reportPayable["field"]["description"] = "Description";
$reportPayable["field"]["amount"] = "Quantity";
$reportPayable["field"]["price"] = "Price";
$reportPayable["field"]["total"] = "Total";

$reportPayable["field"]["tax"] = "Tax";
$reportPayable["field"]["granTotal"] = "Net Total"; // Or "Grand Total" if it includes tax. "Net" usually means before tax.

return $reportPayable;
