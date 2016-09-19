<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UploadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('entity', ChoiceType::class, array(
          'choices' => array(
              'Students' => 'Student',
              'Teachers' => 'Teacher',
              'Grades' => 'Grade',
              'Cause Vox Teams' => 'Causevoxteam',
              'Cause Vox Fundraisers' => 'Causevoxfundraiser',
              'Cause Vox Donations' => 'Causevoxdonation',
              'Offline Donations' => 'Offlinedonation',
            ),
            'disabled' => true,
          )
        )
        ->add('attachment', FileType::class)
        ->add('upload_mode', ChoiceType::class, array(
              'expanded' => true,
              'choices' => array(
                      'Insert/Update (Default)' => 'update',
                      'Truncate (Delete All First)' => 'truncate',
                      'Validate Only (No Database Changes)' => 'validate',
                  ),
              'data' => 'update',
               ));
    }
}
