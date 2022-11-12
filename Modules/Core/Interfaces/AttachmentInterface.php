<?php
/**
 * Created by PhpStorm.
 * User: BaRaa
 * Date: 27/3/2021
 * Time: 2:25 م
 */

namespace Modules\Core\Interfaces;


interface AttachmentInterface
{
    /**
     * @param $attachment
     * @return mixed
     * @author BaRaa
     */
    public function upload($attachment);

    /**
     * @return mixed
     * @author BaRaa
     */
    public function getFullPath();
}
