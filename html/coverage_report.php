<?php

use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Data\RawCodeCoverageData;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Report\Html\Facade as HtmlFacade;

require_once ('vendor/autoload.php');

$coverages = glob('/var/log/coverage/coverage-*.json');


$filter = new Filter;
$finalCoverage = new CodeCoverage(
    driver: (new Selector)->forLineCoverage($filter),
    filter: $filter,
);

foreach ($coverages as $file) {
    $json = json_decode(file_get_contents($file), JSON_OBJECT_AS_ARRAY);

    $finalCoverage->append(RawCodeCoverageData::fromXdebugWithoutPathCoverage($json), str_ireplace(basename($file, '.json'), 'coverage-', ''));
}
$finalCoverage->getData()->markCodeAsExecutedByTestCase()
var_dump($finalCoverage->getData()->lineCoverage());
#$report = new HtmlFacade();
#$report->process($finalCoverage, 'reports');