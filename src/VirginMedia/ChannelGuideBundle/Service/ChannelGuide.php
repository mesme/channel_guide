<?php


namespace VirginMedia\ChannelGuideBundle\Service;


class ChannelGuide {

    protected $connection;
    protected $doctrine;

    public function __construct($dbalConnection, $doctrine)
    {
        $this->connection = $dbalConnection;
        $this->doctrine = $doctrine;
    }

    /**
     * @access public
     * @params package,region
     * return array
     */
    public function getChannels($package,$region)
    {
        $channel_package = $channel_region = array();

        //populate package based on the logic S<M<L
        if($package)
        {
            $sql        = "SELECT p.id FROM package p
                        JOIN closure_table a
                        ON (p.id = a.descendant_id)
                        WHERE a.ancestor_id = (SELECT id from package where name='$package')";

            $stmt       = $this->connection->query($sql);
            $results    = $stmt->fetchAll();

            if(!empty($results))
            {
                $package_array = array();
                foreach($results as $package)
                {
                    $package_array[] = $package['id'];
                }

                $channel_package  = $this->doctrine->getManager()->getRepository('ChannelGuideBundle:Channel')->channelPackage($package_array);
            }
        }

        if($region)
        {
            $channel_region  = $this->doctrine->getManager()->getRepository('ChannelGuideBundle:Channel')->channelRegion($region);
        }

        //if both package and region are selected, return channels that are common
        if(!empty($channel_package) && !empty($channel_region))
        {
            return array_intersect(
                $this->combiner($channel_package),
                $this->combiner($channel_region)
            );
        }

        if(!empty($channel_package))
        {
            return $this->combiner($channel_package);
        }

        if(!empty($channel_region))
        {
            return $this->combiner($channel_region);
        }

    }

    /**
     * @access private
     * @params array
     * return array
     */
    private function combiner($channels)
    {
        $response = array();
        if(!empty($channels))
        {
            foreach($channels as $channel)
            {
                $response[$channel->getNumber()] = $channel->getTitle();
            }
        }
        return $response;
    }

} 