<?php

namespace Plugin\MailChimpAddContact\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists('\Plugin\MailChimpAddContact\Entity\Config', false)) {
    /**
     * Config
     *
     * @ORM\Table(name="plg_mailchimp_add_contact_config")
     * @ORM\Entity(repositoryClass="Plugin\MailChimpAddContact\Repository\ConfigRepository")
     */
    class Config
    {
        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $id;

        /**
         * @var string
         *
         * @ORM\Column(name="server_prefix", type="string", length=255)
         */
        private $server_prefix;

        /**
         * @var string
         *
         * @ORM\Column(name="list_id", type="string", length=255 , nullable=true)
         */
        private $list_id;

        /**
         * @var string
         *
         * @ORM\Column(name="api_key", type="string", length=255)
         */
        private $api_key;

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getListId()
        {
            return $this->list_id;
        }

        /**
         * @param string $list_id
         *
         * @return $this;
         */
        public function setListId($list_id)
        {
            $this->list_id = $list_id;

            return $this;
        }

        /**
         * @return string
         */
        public function getServerPrefix()
        {
            return $this->server_prefix;
        }

        /**
         * @param string $server_prefix
         *
         * @return $this;
         */
        public function setServerPrefix($server_prefix)
        {
            $this->server_prefix = $server_prefix;

            return $this;
        }


        /**
         * @return string
         */
        public function getApiKey()
        {
            return $this->api_key;
        }

        /**
         * @param string $api_key
         *
         * @return $this;
         */
        public function setApiKey($api_key)
        {
            $this->api_key = $api_key;

            return $this;
        }


    }
}
