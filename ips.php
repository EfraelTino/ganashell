<?php  
require 'fpdf.php';
require 'logica/conexion.php';

class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('textures/honda.jpg',10,8,33);
    ;
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(0,125,125);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(100,10,utf8_decode('Registro de Direcciones IP'),1,0,'C');
    
    // Salto de línea
    $this->Ln(20);
    $this->Cell(22,10,utf8_decode('ID'),1,0,'C', 0);
    $this->Cell(40,10,utf8_decode('IP'),1,0,'L', 0);
    $this->Cell(40,10,utf8_decode('FECHA'),1,1,'L', 0);
   

    
    

}
function WriteHTML($html)
{
    // Intérprete de HTML
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Etiqueta
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extraer atributos
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}
function OpenTag($tag, $attr)
{
    // Etiqueta de apertura
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Etiqueta de cierre
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modificar estilo y escoger la fuente correspondiente
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}


//select nombre, farmacia, puntaje, tiempo, fecha, visitor from farmacias INNER JOIN visitadores on farmacias.idvis = visitadores.id

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('*Descarge el archivo en Excel y pulse "SI", para abrir( Windows, Mac).'),0,0,'C');
    
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    $html = '<a href="./exp.php">DESCARGAR PARA EXCEL</a>';
    $this->WriteHTML($html);
}

}
$consulta = "select DISTINCT id, direccion, hora from ips ORDER BY id DESC";
$resultado = $dblink->query($consulta);

$header = array('ID', 'DIRECCION', 'FECHA');
// Creación del objeto de la clase heredada

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pos=0;
while ($row = $resultado-> fetch_assoc()){
    $pos++;
    $pdf->Cell(22,10,utf8_decode('00'.$row['id']),1,0,'C', 0);
    $pdf->Cell(40,10,utf8_decode($row['direccion']),1,0,'L', 0);
    $pdf->Cell(40,10,utf8_decode($row['hora']),1,1,'L', 0);
   

}



//for($i=1;$i<=40;$i++)
 //   $pdf->Cell(0,10,utf8_decode('Imprimiendo línea número ').$i,0,1);
$pdf->Output();

?>