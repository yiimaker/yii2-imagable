<?php

namespace ymaker\imagable\name;

/**
 * Description of CRC32Name
 *
 * @author Ruslan Saiko <ruslan.saiko.dev@gmail.com>
 */
class CRC32Name extends BaseName
{

    public function generate($baseName)
    {
        return hash('crc32', $baseName);
    }

}
