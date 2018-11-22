<?php

function calculaHeuristica($x1, $x2, $y1, $y2) {
    return sqrt((pow(($x2 - $x1), 2) + pow(($y2 - $y1),2)));
}

function getDadosCidade($arrayPontos, $cidade) {
    foreach($arrayPontos as $ponto) {
        if($ponto['cidade'] == $cidade) return $ponto;
    }
}

function imprimirFronteira($fronteira) {
    $arrCaminhos = [];
    
    foreach($fronteira as $caminho => $heuristica) {
        $arrCaminhos[] = "[{$caminho}]({$heuristica})";
        
    }
    
    $linhaCaminho = implode(', ', $arrCaminhos);
    
    echo "F = {{$linhaCaminho}}" . "<br>";
}

function imprimirExplorados($explorados) {
    $strExplorados = implode(', ', $explorados);
    echo "E = {{$strExplorados}}" . "<br><br>";
}

// Definindo as cidades com sua posição x e y com seus respectivos estados filhos para expandir
$pontoA = ['cidade' => 'A', 'x' => 2, 'y' => 4, 'expansoes' => ['B']];
$pontoB = ['cidade' => 'B', 'x' => 5, 'y' => 6, 'expansoes' => ['M', 'C']];
$pontoC = ['cidade' => 'C', 'x' => 4, 'y' => 2, 'expansoes' => ['D']];
$pontoD = ['cidade' => 'D', 'x' => 7, 'y' => 4, 'expansoes' => ['G', 'N', 'Q']];
$pontoF = ['cidade' => 'F', 'x' => 7, 'y' => 8, 'expansoes' => ['Q'];
$pontoG = ['cidade' => 'G', 'x' => 8, 'y' => 2, 'expansoes' => []];
$pontoH = ['cidade' => 'H', 'x' => 10, 'y' => 1, 'expansoes' => ['G']];
$pontoM = ['cidade' => 'M', 'x' => 9, 'y' => 6, 'expansoes' => ['F']];
$pontoN = ['cidade' => 'N', 'x' => 11, 'y' => 3, 'expansoes' => ['H', 'S']];
$pontoP = ['cidade' => 'P', 'x' => 12, 'y' => 5, 'expansoes' => ['N', 'S']];
$pontoQ = ['cidade' => 'Q', 'x' => 11, 'y' => 7, 'expansoes' => ['P']];
$pontoS = ['cidade' => 'S', 'x' => 13, 'y' => 2, 'expansoes' => []];


$todosPontos = [$pontoA,$pontoB,$pontoC,$pontoD,$pontoF,$pontoG,$pontoH,$pontoM,$pontoN,$pontoP,$pontoQ,$pontoS];
$pontoOrigem = $pontoA;
$pontoDestino = $pontoS;

$fronteira = [];
$explorados = [];

$fronteira[$pontoOrigem['cidade']] = calculaHeuristica($pontoOrigem['x'], $pontoDestino['x'], $pontoOrigem['y'], $pontoDestino['y']);


// Percorre enquanto a cabeça for diferente do objetivo
while (($cidadeCabeca = explode(',', array_keys($fronteira)[0])[0]) != $pontoDestino['cidade']) {
    
    // Exibindo fronteira atual
    imprimirFronteira($fronteira);
    
    
    // Pegando dados do primeiro da fronteira
    
    $dadosCidadeCabeca = getDadosCidade($todosPontos, $cidadeCabeca);
    
    reset($fronteira);
    
    // Adicionando os caminhos expandidos na fronteira
    foreach($dadosCidadeCabeca['expansoes'] as $pontoExpansao){
        $dadosPontoExpansao = getDadosCidade($todosPontos, $pontoExpansao);
        
        $heuristicaPontoExpansao = calculaHeuristica($dadosPontoExpansao['x'], $pontoDestino['x'], $dadosPontoExpansao['y'], $pontoDestino['y']);

        $caminho = $pontoExpansao . "," . key($fronteira);

        $fronteira[$caminho] = $heuristicaPontoExpansao;
    }
    
    // Removendo a cabeça antiga
    array_shift($fronteira);
    
    // Ordenando a fronteira
    uasort($fronteira, function ($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    });
    
    
    imprimirExplorados($explorados);
    
    // Adicionando nos explorados
    array_push($explorados, $cidadeCabeca);

}

// Exibindo fronteira e explorados final
imprimirFronteira($fronteira);
imprimirExplorados($explorados);

?>
