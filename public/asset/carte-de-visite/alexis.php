<?php
header('Content-Type: text/vcard; charset=utf-8');
header('Content-Disposition: inline; filename="Alexis.vcf"');
echo "BEGIN:VCARD\r\n";
echo "VERSION:3.0\r\n";
echo "FN:Alexis\r\n";
echo "N:;Alexis;;;\r\n";
echo "TEL;TYPE=CELL:+33768882768\r\n";
echo "EMAIL:contact@Alex2.dev\r\n";
echo "URL:https://www.Alex2.dev\r\n";
echo "TITLE:Back-end · PHP · APIs · Docker\r\n";
echo "ORG:Alex²\r\n";
echo "END:VCARD\r\n";
