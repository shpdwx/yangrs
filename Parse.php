<?php

namespace Taco;

class Parse
{

    /**
     * 文件名
     * @var string|null
     */
    protected ?string $filename;


    /**
     * @param string|null $filename
     */
    public function __construct(?string $filename)
    {
        $this->filename = $filename;
    }


    /**
     * @return \Generator
     */
    protected function getCsv()
    {
        // 文件真实性
        if (file_exists($this->filename)) {
            $handle = fopen($this->filename, "r");
            $firstFlag = true;
            $header = [];
            // 逐行读取csv
            while (($line = fgetcsv($handle)) !== false) {

                // 首行标题不处理
                if ($firstFlag) {
                    $header = $line;
                    $firstFlag = false;
                    continue;
                }
                if (!empty($line)) {
                    // 合并标题与内容，形成hash
                    yield array_combine($header, $line); # @todo可续可完善下kv数量异常时
                } else {
                    fclose($handle);
                }
            }
        }
    }


    /**
     * @return bool
     */
    public function getTaco()
    {
        $format = "`%s` - `%s`\n";
        $nameField = "Applicant";
        $data = $this->getCsv();
        if (!$data->valid()) {
            print_r("获取信息失败\n");
            return false;
        }
        foreach ($data as $line) {
            if (stripos($line["Applicant"], "taco") !== false) {
                printf($format, $line[$nameField], $line["locationid"]);
                continue;
            }
            if (stripos($line["FoodItems"], "taco") !== false) {
                printf($format, $line[$nameField], $line["locationid"]);
            }
        }
        return true;
    }
}