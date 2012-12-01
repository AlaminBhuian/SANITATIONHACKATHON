<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    public function getBasicData($type_id)
    {
        $cacheData = "cacheCategory_" . $type_id;
        if (!$rs = $this->cache->get($cacheData))
        {
            $this->db->select('id, intBasicCategoryId, varName');
            $this->db->where("intBasicCategoryId", $type_id);
            $this->db->where("enuStatus", 'active');
            $this->db->order_by("sortOrder", "DESC");
            $this->db->order_by("varName", "ASC");
            $rs = $this->db->get('basic_data')->result_array();
            $this->cache->save($cacheData, $rs);
        }
        return $rs;
    }

    public function buildComplaintTrackingNo($preStr = "")
    {
        //build tracking# prefix                
        $preStr .= date("ymd") . "-";
        // get last tracking number
        $query = $this->db->select('traking_number')
                ->like('traking_number', $preStr, 'after')
                ->limit(1)
                ->order_by("traking_number", "DESC")
                ->get('complaint');
        $result = $query->row();
        if ($query->num_rows() == 1)
        {
            $preStr .= $this->increaseNumber($result->{'traking_number'}, strlen($preStr));
        } else
        {
            $preStr .= "0001";
        }
        return $preStr;
    }

    public function increaseNumber($str, $len)
    {
        // split post number and increase 1
        $number = (int) substr($str, $len) + 1;
        // zero fill
        if (strlen((string) $number) == 1)
        {
            return '000' . $number;
        } else if (strlen((string) $number) == 2)
        {
            return '00' . $number;
        } else if (strlen((string) $number) == 3)
        {
            return '0' . $number;
        } else
        {
            return $number;
        }
    }

    public function getDistricts()
    {
        if (!$rs = $this->cache->get('cacheDistricts'))
        {
            $this->db->select('district_id, district_name');
            $this->db->order_by("district_name", "ASC");
            $rs = $this->db->get('district')->result_array();
            $this->cache->save('cacheDistricts', $rs);
        }
        return $rs;
    }

    public function getSubDistricts($district_id)
    {
        $cacheData = "cacheSubDistricts_" . $district_id;
        if (!$rs = $this->cache->get($cacheData))
        {
            $this->db->select('sub_district_id, sub_district_name, district_id');
            $this->db->where("district_id", $district_id);
            $this->db->order_by("sub_district_name", "ASC");
            $rs = $this->db->get('sub_district')->result_array();
            $this->cache->save($cacheData, $rs);
        }
        return $rs;
    }

    public function getAllComplaintStatus()
    {
        if (!$rs = $this->cache->get('cacheAllComplaintStatus'))
        {
            $this->db->select('status_id, name, mode');
            $this->db->order_by("name", "ASC");
            $this->db->where("status", 'Active');
            $rs = $this->db->get('status')->result_array();
            $this->cache->save('cacheAllComplaintStatus', $rs);
        }
        return $rs;
    }

    public function getAllDesk()
    {
        if (!$rs = $this->cache->get('cacheAllDesk'))
        {
            $this->db->select('desk_id, name');
            $this->db->order_by("name", "ASC");
            $this->db->where("status", 'Active');
            $rs = $this->db->get('desk')->result_array();
            $this->cache->save('cacheAllDesk', $rs);
        }
        return $rs;
    }

    public function getTotalSubmittedComplaint($type)
    {
        $cacheData = "cacheTotalSubmittedComplaint_" . $type;
        if (!$rs = $this->cache->get($cacheData))
        {
            $sql = "SELECT COUNT(*) AS totalComplaint FROM complaint WHERE 1=1";

            if ($type == 'today')
            {
                $sql .= " AND DATE(dtInsertDT) = CURRENT_DATE()";
            }
            if ($type == 'lastweek')
            {
                $sql .= " AND DATE(dtInsertDT) BETWEEN DATE_SUB(CURRENT_DATE(), INTERVAL 8 DAY) AND DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
            }
            if ($type == 'lastmonth')
            {
                $sql .= " AND DATE(dtInsertDT) BETWEEN DATE_SUB(CURRENT_DATE(), INTERVAL 31 DAY) AND DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
            }

            $rs = $this->db->query($sql)->row();
            $this->cache->save($cacheData, $rs, $this->config->item('site.limit'));
        }
        return $rs;
    }

    public function getTotalMyDeskComplaint($desk_id)
    {
        $cacheData = "cacheTotalMyDeskComplaint_" . $desk_id;
        if (!$rs = $this->cache->get($cacheData))
        {
            $sql = "SELECT
                        complaint.complaint_id,
                        `status`.`name`,
                        COUNT(`status`.status_id) as totalComplaint
                    FROM
                        complaint
                        INNER JOIN `status` ON `status`.status_id = complaint.present_status
                    WHERE
                        complaint.present_desk = ?
                    GROUP BY `status`.status_id
                    ORDER BY `status`.`name` ASC";
            $binds = array($desk_id);
            $rs = $this->db->query($sql, $binds)->result_array();
            $this->cache->save($cacheData, $rs, $this->config->item('site.limit'));
        }
        return $rs;
    }

}