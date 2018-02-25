<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Base\BaseEntity;
use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\ThingTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImportDirectoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ImportDirectory extends BaseEntity
{
    use IdTrait;
    use ThingTrait;
    use AddressTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $sellingPrice;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $rendingPrice;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $imageGuid;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $category;


    /**
     * constructs a valid url for the frontend
     * @return string
     */
    public function getImageUrl()
    {
        return "https://media.home.ch/www/ftp/wic/images/" . $this->getImageGuid();
    }

    /**
     * @return mixed
     */
    public function getImageGuid()
    {
        return $this->imageGuid;
    }

    /**
     * @param mixed $imageGuid
     */
    public function setImageGuid($imageGuid): void
    {
        $this->imageGuid = $imageGuid;
    }

    /**
     * @return string
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * @param string $sellingPrice
     */
    public function setSellingPrice(string $sellingPrice): void
    {
        $this->sellingPrice = $sellingPrice;
    }

    /**
     * @return string
     */
    public function getRendingPrice()
    {
        return $this->rendingPrice;
    }

    /**
     * @param string $rendingPrice
     */
    public function setRendingPrice(string $rendingPrice): void
    {
        $this->rendingPrice = $rendingPrice;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }
}
