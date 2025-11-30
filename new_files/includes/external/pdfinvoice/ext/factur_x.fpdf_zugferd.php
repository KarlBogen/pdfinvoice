<?php
/*
https://www.fpdf.org/en/script/script104.php
2024-12-26	Olivier	ZUGFeRD / Factur-X support
*/

class PDF_ZUGFeRD
{

  public $extraXMPRDF;
  public $extraXMPPdfaextension;
  public $filename;
  protected $profile;

  public function __construct($profile)
  {
    $this->SetFileName($profile);
    $this->extraXMPRDF = $this->_getxmpextrardf();
    $this->extraXMPPdfaextension = $this->_getxmpextrapdfa();
  }

  protected function SetFileName($profile = 'EN 16931')
  {
    if (!in_array($profile, array('MINIMUM', 'BASIC WL', 'BASIC', 'EN 16931', 'EXTENDED', 'XRECHNUNG')))
      echo 'Incorrect profile: ' . $profile;
    $this->profile = $profile;

    if ($profile == 'XRECHNUNG')
      $this->filename = 'xrechnung.xml';
    else
      $this->filename = 'factur-x.xml';
  }

  protected function _getxmpextrardf()
  {
    if (empty($this->filename))
      return;
    $fx = $this->_getxmpsimple('fx:DocumentType', 'INVOICE');
    $fx .= $this->_getxmpsimple('fx:DocumentFileName', $this->filename);
    $fx .= $this->_getxmpsimple('fx:Version', '1.0');
    $fx .= $this->_getxmpsimple('fx:ConformanceLevel', $this->profile);

    $extra = file_get_contents(__DIR__ . '/xmp-extension.txt');
    $extra = $this->_getxmpdescription('fx', 'urn:factur-x:pdfa:CrossIndustryDocument:invoice:1p0#', $fx);
    return $extra;
  }

  protected function _getxmpextrapdfa()
  {
    if (empty($this->filename))
      return;

    $extra = file_get_contents(__DIR__ . '/xmppdfa-extension.txt');
    return $extra;
  }

  protected function _getxmpdescription($prefix, $ns, $body)
  {
    return sprintf("<rdf:Description xmlns:%s=\"%s\" rdf:about=\"\">\n%s</rdf:Description>\n", $prefix, $ns, $body);
  }

  protected function _getxmpsimple($tag, $value)
  {
    $value = htmlspecialchars($value, ENT_XML1, 'UTF-8');
    return sprintf("\t<%s>%s</%s>\n", $tag, $value, $tag);
  }
}
