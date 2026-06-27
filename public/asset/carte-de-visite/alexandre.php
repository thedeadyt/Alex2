<?php
header('Content-Type: text/vcard; charset=utf-8');
header('Content-Disposition: inline; filename="Alexandre.vcf"');
echo "BEGIN:VCARD\r\n";
echo "VERSION:3.0\r\n";
echo "FN:Alexandre\r\n";
echo "N:;Alexandre;;;\r\n";
echo "TEL;TYPE=CELL:+33686825714\r\n";
echo "EMAIL:contact@Alex2.dev\r\n";
echo "URL:https://www.Alex2.dev\r\n";
echo "TITLE:Front-end · React · UX/UI\r\n";
echo "ORG:Alex²\r\n";
echo "END:VCARD\r\n";
