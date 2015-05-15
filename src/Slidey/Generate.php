<?php
/**
 * Created by Gary Hockin.
 * Date: 15/05/15
 * @GeeH
 */
namespace Slidey;

class Generate
{

    /**
     * @var string
     */
    protected $html = '';
    /**
     * Base directory for slides
     */
    const BASE_DIR = './slides/';
    /**
     * Title slides directory
     */
    const TITLE_DIR = 'title/';
    /**
     * Content slides directory
     */
    const CONTENT_DIR = 'content/';
    /**
     * End slides directory
     */
    const FINISH_DIR = 'finish/';

    /**
     * Template to use to write the slides
     */
    const TEMPLATE_FILE = './public/source.html';
    /**
     * File to overwrite with the new slides
     */
    const DESTINATION_FILE = './public/index.html';
    /**
     * Number of body slides to use§
     */
    const BODY_SLIDES = 4;

    /**
     * @param $name
     */
    public function __invoke($name)
    {
        $this->pickRandomTitle($name);
        $this->pickRandomContent($name);
        $this->pickRandomFinish($name);
        $this->writeSlides();
    }

    /**
     * @param $name
     */
    private function pickRandomFinish($name)
    {
        $slides = $this->getSlides(self::FINISH_DIR);
        $slide  = $slides[array_rand($slides)];
        echo 'Picked slide: ' . $slide . PHP_EOL;

        $html = file_get_contents($slide);
        $html = str_replace('{#NAME!#}', $name, $html);
        $this->addSection($slide, $html);
    }

    /**
     * @param $name
     */
    private function pickRandomTitle($name)
    {
        $slides = $this->getSlides(self::TITLE_DIR);
        $slide  = $slides[array_rand($slides)];
        echo 'Picked slide: ' . $slide . PHP_EOL;

        $html = file_get_contents($slide);
        $html = str_replace('{#NAME!#}', $name, $html);
        $this->addSection($slide, $html);
    }

    /**
     * @param $name
     */
    private function pickRandomContent($name)
    {
        $slides = $this->getSlides(self::CONTENT_DIR);
        shuffle($slides);

        $count = 0;

        while($count <= self::BODY_SLIDES) {
            if(count($slides) === 0) {
                break;
            }

            $slide  = array_shift($slides);
            echo 'Picked slide: ' . $slide . PHP_EOL;
            $html = file_get_contents($slide);
            $html = str_replace('{#NAME!#}', $name, $html);

            $this->addSection($slide, $html);
            $count++;
        }


    }

    /**
     * @param $slide
     * @param $html
     */
    private function addSection($slide, $html)
    {
        $isMarkdown = substr($slide, -3) === '.md' ? true : false;
        $newHtml = '<section';
        if ($isMarkdown) {
            $newHtml .= ' data-markdown>' . PHP_EOL;
            $newHtml .= '<script type="text/template">' . PHP_EOL;
        } else {
            $newHtml .= '>' . PHP_EOL;
        }
        $newHtml .= $html . PHP_EOL;
        if ($isMarkdown) {
            $newHtml .= '</script>' . PHP_EOL;
        }
        $newHtml .= '</section>' . PHP_EOL;
        $this->html .= $newHtml;
    }

    private function writeSlides()
    {
        $template = file_get_contents(self::TEMPLATE_FILE);
        $template = str_replace('{#SLIDES!#}', $this->html, $template);
        file_put_contents(self::DESTINATION_FILE, $template);
    }

    /**
     * @return array
     */
    private function getSlides($dir)
    {
        $files  = self::BASE_DIR . $dir . '{*.html,*.md}';
        $slides = glob($files, GLOB_BRACE);

        return $slides;
    }

}