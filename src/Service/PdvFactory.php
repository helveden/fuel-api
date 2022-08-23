<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Pdv;
use App\Entity\User;

class PdvFactory extends AbstractFactory {

    private $em;

    public function __construct(
        EntityManagerInterface $em,
        Security $security
    )
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function get(int $id) {
        return $this->em->getRepository(Pdv::class)->find($id);
    }

    public function getBy($params = []) {
        return $this->em->getRepository(Pdv::class)->findOneBy($params);
    }
    
    public function filter(array $params = []) {

    }

    public function saveCommandAll(array $pdvs = [], $io) {
        $io->progressStart();

        foreach ($io->progressIterate($pdvs) as $k => $pdv) {
            $this->save($pdv);
        }

        $io->progressFinish();
    }

    public function save($pdv) {
        $datas = [];

        $pdvDatas = json_decode($pdv, true);
        // savoir si le pdv existe
        $pdv = $this->getBy([
            'pdv_id' => $pdvDatas['@attributes']['id']
        ]);
        
        if($pdv === null):
            $pdv = new Pdv();
            $pdv->setPdvId($pdvDatas['@attributes']['id']);
            $pdv->setLatitude($pdvDatas['@attributes']['latitude']);
            $pdv->setLongitude($pdvDatas['@attributes']['longitude']);
            $pdv->setPostalcode($pdvDatas['@attributes']['cp']);
            $pdv->setAdresse($pdvDatas['adresse']);
            $pdv->setCity($pdvDatas['ville']); 
        endif;
        
        $jours = [];
        $automate2424 = "";
        if(!empty($pdvDatas['horaires'])):
            foreach($pdvDatas['horaires']['jour'] as $k => $j):
                $jours[] = $j['@attributes'];
            endforeach;
            $automate2424 = $pdvDatas['horaires']['@attributes']["automate-24-24"];
        endif;

        $prices = [];
        if(!empty($pdvDatas['prix'])):
            foreach($pdvDatas['prix'] as $k => $p):
                $prices[] = !empty($p['@attributes']) ? $p['@attributes'] : [];
            endforeach;
        endif;
        
        $services = [];
        if(!empty($pdvDatas['services'])):
            if(!empty($pdvDatas['services']['service'])):
                $services = $pdvDatas['services']['service'];
            endif;
        endif;

        $datas = [
            'id'             => $pdvDatas['@attributes']['id'],
            'latitude'       => $pdvDatas['@attributes']['latitude'],
            'longitude'      => $pdvDatas['@attributes']['longitude'],
            'cp'             => $pdvDatas['@attributes']['cp'],
            'pop'            => $pdvDatas['@attributes']['pop'],
            'adresse'        => $pdvDatas['adresse'],
            'ville'          => $pdvDatas['ville'],
            'services'       => $services,
            'horaires'       => $jours,
            'prix'           => $prices,
            "automate-24-24" => $automate2424,
        ];

        $pdv->setDatas($datas);

        $this->em->persist($pdv);
        $this->em->flush();

        return $datas;
    }
}