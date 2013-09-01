<?php

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once("../../livros/controller/Controller.php");
require_once("../fpdf17/fpdf.php");
define('FPDF_FONTPATH', '../fpdf17/font/');

$ano = $_GET['ano'];
$nome = $_GET['nomeLivro'];
$pdf = new FPDF("P", "mm", "A4");
$pdf->Cell(80);
$pdf->Cell(30, 10, 'Title', 1, 0, 'C');
$pdf->Ln(20);
$pdf->SetSubject("Saídas de Registros");

// ------ Cabeçalho Imagem ------

$pdf->SetY("-1");
$pdf->Cell(0, 5, '', 0, 0, 'L');
$pdf->Image('../images/cabecalho.jpg', 34.43, 10, 141.14, 21.9, 'JPG');

// ------ Cabeçalho Texto ------

$pdf->SetY("21");
$pdf->SetX("20");
$pdf->Ln(20);
$pdf->SetFont('arial', 'B', 10);
$pdf->SetX("25");
$texto = utf8_decode('Relatório de saída de registros');
$pdf->Cell(160, 5, $texto, 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX("25");
$texto = utf8_decode('Nome - '.$nome.'  /  Ano - ' .$ano);
$pdf->Cell(160, 5, $texto, 'B', 0, 'C');
$pdf->Ln(5);

// ----------------------------

$largura = 40;
$altura = 6;
$hist = retornaHistoricoSaida_porNome($nome, $ano);
$id = -1;
$destino = -1;
$novoLivro = false;
$tamanho = sizeof($hist);
$totalEntrada = 0;
$totalSaida = 0;
$quantidadeSaida;

$i = 0;
for ($i; $i < $tamanho; $i++) {
    if ($id != $hist[$i]["livroid"]) {

        // ----- Contagem final de cada livro -----

        if ($i > 0) {
            $i--;
            $pdf->SetFont('arial', 'B', 8);
            $totalEntrada += $quantidadeTotal = $hist[$i]["quantidade"] + $quantidadeSaida;
            $pdf->SetX("25");
            $pdf->Cell(90, $altura, '', 'TL', 0, 'C');
            $pdf->Cell(70, $altura, 'Entrada: ' . $quantidadeTotal . ' registro(s)', 'TR', 1, 'R');
            $pdf->SetX("25");
            $pdf->Cell(90, $altura, '', 'L', 0, 'C');
            $texto = utf8_decode('Total Saída: ');
            $pdf->Cell(70, $altura, $texto . $quantidadeSaida . ' registro(s)', 'R', 1, 'R');
            $pdf->SetX("25");
            $pdf->Cell(90, $altura, '', 'LB', 0, 'C');
            $pdf->Cell(70, $altura, 'Estoque: ' . $hist[$i]["quantidade"] . ' registro(s)', 'RB', 1, 'R');
            $i++;
        }
        $pdf->Ln(10);

        // ----- Nome -----

        $pdf->SetX("25");
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(12, $altura, 'Nome: ', 'LT', 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $texto = utf8_decode($hist[$i]["nomeLivro"]);
        $pdf->Cell(148, $altura, $texto, 'TR', 1, 'L');

        // ----- Empenho -----

        $pdf->SetX("25");
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(18, $altura, 'Empenho: ', 'LT', 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $texto = utf8_decode($hist[$i]["numeroEmpenho"]);
        $pdf->Cell(142, $altura, $texto, 'TR', 1, 'L');

        // ----- Gráfica -----

        $pdf->SetX("25");
        $pdf->SetFont('arial', 'B', 10);
        $texto = utf8_decode('Gráfica: ');
        $pdf->Cell(14, $altura, $texto, 'LT', 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $texto = utf8_decode($hist[$i]["nomeGrafica"]);
        $pdf->Cell(102, $altura, $texto, 'TR', 0, 'L');

        // ----- Data Entrada -----

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(24, $altura, 'Data Entrada: ', 'LT', 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $texto = utf8_decode($hist[$i]["dataEntrada"]);
        $pdf->Cell(20, $altura, $texto, 'TR', 1, 'R');

        $pdf->SetX("25");
        $pdf->Cell(160, 2, '', 1, 1, 'L');
        
        $novoLivro = true;
        $id = $hist[$i]["livroid"];
        $quantidadeSaida = 0;
    }
    
    if ($destino != $hist[$i]["destinoid"] || $novoLivro) {

        // ----- Destino -----

        $pdf->SetX("25");
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(15, $altura, 'Destino: ', 'LT', 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $texto = utf8_decode($hist[$i]["descricao"]);
        $pdf->Cell(145, $altura, $texto, 'TR', 1, 'L');

        // ----- Quantidade Saída -----

        $pdf->SetFont('arial', 'B', 10);
        $pdf->SetX("25");
        $texto = utf8_decode('Qtde Saída');
        $pdf->Cell(20, $altura, $texto, 1, 0, 'C');

        // ----- Data Saída -----

        $texto = utf8_decode('Data Saída');
        $pdf->Cell(20, $altura, $texto, 1, 0, 'C');

        // ----- Curso -----

        $pdf->Cell(120, $altura, 'Curso', 1, 1, 'C');

        // ----------------

        $destino = $hist[$i]["destinoid"];
        $novoLivro = false;
    }

    // ----- Quantidade Saída -----

    $pdf->SetFont('arial', '', 10);
    $pdf->SetX("25");
    $texto = $hist[$i]["quantidadeSaida"];
    $pdf->Cell(20, $altura, $texto, 1, 0, 'C');

    // ----- Data Saída -----

    $texto = $hist[$i]["dataSaida"];
    $pdf->Cell(20, $altura, $texto, 1, 0, 'C');

    // ----- Curso -----

    $texto = utf8_decode($hist[$i]["nomeCurso"]);
    $pdf->Cell(120, $altura, $texto, 1, 1, 'L');

    // ------------------

    $quantidadeSaida += $hist[$i]["quantidadeSaida"];
    $totalSaida += $hist[$i]["quantidadeSaida"];
}

// ----- Contagem final do último livro -----

if ($i > 0) {
    $i--;
    $pdf->SetFont('arial', 'B', 8);
    $totalEntrada += $quantidadeTotal = $hist[$i]["quantidade"] + $quantidadeSaida;
    $pdf->SetX("25");
    $pdf->Cell(90, $altura, '', 'TL', 0, 'C');
    $pdf->Cell(70, $altura, 'Entrada: ' . $quantidadeTotal . ' registro(s)', 'TR', 1, 'R');
    $pdf->SetX("25");
    $pdf->Cell(90, $altura, '', 'L', 0, 'C');
    $texto = utf8_decode('Total Saída: ');
    $pdf->Cell(70, $altura, $texto . $quantidadeSaida . ' registro(s)', 'R', 1, 'R');
    $pdf->SetX("25");
    $pdf->Cell(90, $altura, '', 'LB', 0, 'C');
    $pdf->Cell(70, $altura, 'Estoque: ' . $hist[$i]["quantidade"] . ' registro(s)', 'RB', 1, 'R');
}

// ----- Contagem final geral -----

$pdf->Ln(15);
$pdf->SetFont('arial', 'B', 10);
$pdf->SetX("110");
$pdf->Cell(70, $altura, 'Total de entradas no ano: ' . $totalEntrada . ' registro(s)', 0, 1, 'R');
$pdf->SetX("110");
$texto = utf8_decode('Total de saídas no ano: ');
$pdf->Cell(70, $altura, $texto . $totalSaida . ' registro(s)', 0, 1, 'R');
$pdf->SetX("110");
$pdf->Cell(70, $altura, 'Total em estoque: ' . ($totalEntrada - $totalSaida) . ' registro(s)', 0, 1, 'R');

// ----- Rodapé -----

$pdf->SetFont('arial', '', 7);
$pdf->SetY("270");
$data = date("d/m/Y");
$conteudo = "Criado em " . $data;
$texto = $conteudo . " por CEAD/Unifal-MG";
$pdf->Cell(170, $altura, $texto, 0, 1, 'R');

// ----- Gera PDF -----

$pdf->Output("arquivo", "I");
?>
    