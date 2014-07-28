<?php

namespace Hyperreal\AcaciaBundle\Form;

class EditAnnouncementFormType extends AddAnnouncementFormType
{
    public function getName()
    {
        return 'acacia_user_edit_announcement';
    }
}