<?php declare(strict_types=1);

$dataString = require_once __DIR__ . '/common_words.php';

$dataArray = explode(PHP_EOL, trim($dataString));
$sqlData   = [];

/**
 * @param $rank
 * @return string|string[]|null
 */
function keepFirstNumber($rank)
{
    if ($rank === '(a)') {
        return 'null';
    }

    return (int)preg_replace('/^([0-9]+).*$/', '$1', $rank);
}

foreach ($dataArray as $singleEntry) {
    list($word, $type, $oecRank, $cocaRank) = explode("\t", $singleEntry);
    $sqlData [] = sprintf('"%s", %d, %s', $word, keepFirstNumber($oecRank), keepFirstNumber($cocaRank));
}

echo sprintf(
    "INSERT INTO `most_common_words` (`word`, `oec_rank`, `coca_rank`) VALUES \n(%s) ON DUPLICATE KEY UPDATE `id` = `id`",
    implode("),\n(", $sqlData)
);
//var_export($dataArray);
