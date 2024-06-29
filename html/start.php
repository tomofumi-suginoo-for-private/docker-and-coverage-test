<?php
if (php_sapi_name() != 'cli') {
    xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

    class CoverageDumper {
        private string $testName;
        function __construct(string $testName)
        {
            $this->testName = $testName;
        }
        
        function __destruct()
        {
            $coverageName = '/var/log/coverage/coverage-' . $this->testName . '-' . microtime(true);
            try {
                xdebug_stop_code_coverage(false);
                $codecoverageData = json_encode(xdebug_get_code_coverage());
                
                file_put_contents($coverageName . '.json', $codecoverageData);
            } catch (Exception $ex) {
                file_put_contents($coverageName . '.ex', $ex);
            }
        }
    }
    $testName = (isset($_COOKIE['test_name']) && !empty($_COOKIE['test_name'])) ? $_COOKIE['test_name'] : 'unknown_test_' . time();
    $_coverageDumper = new CoverageDumper($testName);
}
