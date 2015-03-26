<?php
namespace VirginMedia\ChannelGuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class FilterType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('package', 'entity', array(
                'class' => 'ChannelGuideBundle:Package',
                'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('p')->orderBy('p.name', 'DESC');
                    },
                'expanded' => false,
                'required' => false
            ))
            ->add('region', 'entity', array(
                'class' => 'ChannelGuideBundle:Region',
                'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('r')->orderBy('r.name', 'ASC');
                    },
                'expanded' => false,
                'required' => false
            ))
            ;
    }

    public function getName()
    {
        return 'filter';
    }


}