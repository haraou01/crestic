<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Financeurs
 *
 * @ORM\Table()
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FinanceursRepository")
 */
class Financeurs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255,nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="typeFinanceur", type="string", length=1)
     */
    private $typeFinanceur = 'A';

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255,nullable=true)
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(name="internationale", type="boolean",nullable=true)
     */
    private $internationale = False;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image = 'noimage.png';

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="partenaires_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var \DateTime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     *
     * @ORM\OneToMany(targetEntity="ProjetsHasFinanceurs", mappedBy="financeur", cascade={"persist"})
     */
    private $projets;

    public function __toString()
    {
        return $this->getNom();
    }

    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->equipes = new ArrayCollection();
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Financeurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Financeurs
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Financeurs
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image)
        {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTime('now'));
        }
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Financeurs
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Financeurs
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Set internationale
     *
     * @param boolean $internationale
     *
     * @return Financeurs
     */
    public function setInternationale($internationale)
    {
        $this->internationale = $internationale;

        return $this;
    }

    /**
     * Get internationale
     *
     * @return boolean
     */
    public function getInternationale()
    {
        return $this->internationale;
    }

    /**
     * Add projet
     *
     * @param ProjetsHasFinanceurs $projet
     *
     * @return Financeurs
     */
    public function addProjet(ProjetsHasFinanceurs $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     *
     * @param ProjetsHasFinanceurs $projet
     */
    public function removeProjet(ProjetsHasFinanceurs $projet)
    {
        $this->projets->removeElement($projet);
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * Set typeFinanceur
     *
     * @param string $typeFinanceur
     *
     * @return Financeurs
     */
    public function setTypeFinanceur($typeFinanceur)
    {
        $this->typeFinanceur = $typeFinanceur;

        return $this;
    }

    /**
     * Get typeFinanceur
     *
     * @return string
     */
    public function getTypeFinanceur()
    {
        return $this->typeFinanceur;
    }

    /**
     * Get typeFinanceurLong
     *
     * @return string
     */
    public function getTypeFinanceurLong()
    {
        if ($this->typeFinanceur === 'A') {
            return 'Académique';
        }

        return 'Industriel';
    }
}
