<?php

class Composer {

    protected $path;
    protected $binary;

    public function __construct($path = './', $binary = 'composer') {
        $this->path = $path;
        $this->binary = $binary;
    }

    public function composerFileExists(){
        return is_file($this->getComposerFilePath());
    }

    public function getInstalledPackages(){
        ob_start();
        passthru('cd ' . $this->path . ' && ' . $this->binary . ' show -f json');
        $infos = ob_get_contents();
        ob_end_clean();
        return json_decode($infos);
    }

    public function getConfig(){
        ob_start();
        passthru('cd ' . $this->path . ' && ' . $this->binary . ' config --list');
        $infos = ob_get_contents();
        ob_end_clean();
        return $infos;
    }

    public function getComposerFile($raw = false){
        if($this->composerFileExists()){
            $contents = file_get_contents($this->getComposerFilePath());
            return $raw ? $contents : json_decode($contents, true);
        }
    }

    public function getComposerFilePath(){
        return realpath($this->path).'/composer.json';
    }

    public function saveComposerFile($contents){
        return file_put_contents($this->getComposerFilePath(), $contents);
    }

    public function runCommand($cmd){
        echo '#' . ' cd ' . $this->path . ' && ' . $this->binary . ' ' . $cmd . ' --no-interaction' . "\n";
        system('cd ' . $this->path . ' && ' . $this->binary . ' ' . $cmd . ' --no-interaction');
        echo 'done';
        exit();
    }

}
