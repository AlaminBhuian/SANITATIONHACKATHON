<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();        
    }

    public function getCurrentExam()
    {
        if (!$currentExamInfo = $this->cache->get('currentExamInfo'))
        {
            $sql = "SELECT
                        TBL_EXAMINATION.NUMID AS CURR_EXAM_ID,
                        TBL_EXAMINATION_NAME.STR_ELEMENT_NAME AS EXAMINATION_NAME,
                        TBL_EXAMINATION_YEAR.STR_ELEMENT_NAME AS EXAMINATION_YEAR,
                        TBL_TH.STR_ELEMENT_NAME AS EXAM_TH
                     FROM
                        TBL_EXAMINATION
                        INNER JOIN TBL_EXAMINATION_NAME ON TBL_EXAMINATION_NAME.NUMID = TBL_EXAMINATION.NUM_EXAMINATION_NAME_ID
                        INNER JOIN TBL_EXAMINATION_YEAR ON TBL_EXAMINATION_YEAR.NUMID = TBL_EXAMINATION.NUM_EXAMINATION_YEAR_ID
                        INNER JOIN TBL_TH ON TBL_TH.NUMID = TBL_EXAMINATION.NUM_TH_ID
                     WHERE
                        TBL_EXAMINATION.IS_CURRENT_EXAM = " . $this->config->item('ACTIVE');

            $currentExamInfo = $this->db->query($sql)->result_array();
            $this->cache->save('currentExamInfo', $currentExamInfo);
        }

        return $currentExamInfo;
    }

    public function getAllLevel()
    {
        if (!$rsAllLevel = $this->cache->get('rsAllLevel'))
        {
            $this->db->select('NUMID, STR_ELEMENT_NAME');
            $this->db->order_by("STR_ELEMENT_NAME", "ASC");
            $rsAllLevel = $this->db->get('TBL_LEVEL')->result_array();
            $this->cache->save('rsAllLevel', $rsAllLevel);
        }
        return $rsAllLevel;
    }

   
    public function make_dir($path, $rights = 0775)
    {
        $folder_path = array(strstr($path, '.') ? dirname($path) : $path);
        while (!@is_dir(dirname(end($folder_path)))
        && dirname(end($folder_path)) != '/'
        && dirname(end($folder_path)) != '.'
        && dirname(end($folder_path)) != '')
        {
            array_push($folder_path, dirname(end($folder_path)));
        }

        while ($parent_folder_path = array_pop($folder_path))
        {
            if (!@mkdir($parent_folder_path, $rights))
            {
                //user_error("Can't create folder \"$parent_folder_path\".");
            }
        }
    }

    /*
     * crop image
     */

    public function cropImage($filePath, $dimesion_type = NULL)
    {
        $dimensions = $this->config->item('IMG_CROP');

        foreach ($dimensions as $key => $val)
        {
            list($H, $W) = explode(',', $val);
            $H = (int) $H;
            $W = (int) $W;
            if (is_string($filePath))
            {
                $this->processImage($filePath, $H, $W);
            }
        }
    }

    /*
     * image resize
     *
     * @access public
     * @param   filePath    originial file location
     * @param   height      new image height
     * @param   width       new image width
     * @retun   new image path
     */

    public function processImage($filePath, $height, $width)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $filePath; // '/path/to/image/mypic.jpg';
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = "_{$width}x{$height}_thumb";
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        // load image libs     
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        return $this->buildNewFileName($filePath, $width, $height);
    }

    /*
     * build new image file name
     *
     * @access  public
     * @param   fileName    file location
     * @return  string      new file path
     */

    public function buildNewFileName($fileName, $w, $h)
    {
        $ext = $this->findFileExtension($fileName);
        $fileName = substr($fileName, 0, -(strlen($ext)));
        return $fileName = $fileName . "_{$w}x{$h}_thumb" . $ext;
    }

    /*
     * Find file extension
     *
     * @access  public
     * @param   filename    file name or path
     * @return  string      file extension
     */

    public function findFileExtension($filename)
    {
        $filename = strtolower($filename);
        $exts = strrchr($filename, '.');
        return $exts;
    }

    public function setExamNumber($number)
    {
        // zero fill
        if (strlen((string) $number) == 1)
        {
            return '00' . $number;
        } if (strlen((string) $number) == 2)
        {
            return '0' . $number;
        } else
        {
            return $number;
        }
    }

    public function setSlNumber($number)
    {
        // zero fill
        if (strlen((string) $number) == 1)
        {
            return '00000' . $number;
        } if (strlen((string) $number) == 2)
        {
            return '0000' . $number;
        } if (strlen((string) $number) == 3)
        {
            return '000' . $number;
        } if (strlen((string) $number) == 4)
        {
            return '00' . $number;
        } if (strlen((string) $number) == 5)
        {
            return '0' . $number;
        } else
        {
            return $number;
        }
    }

   
    
}