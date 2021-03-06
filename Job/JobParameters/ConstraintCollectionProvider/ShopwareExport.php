<?php

namespace Basecom\Bundle\ShopwareConnectorBundle\Job\JobParameters\ConstraintCollectionProvider;

use Akeneo\Component\Batch\Job\JobInterface;
use Akeneo\Component\Batch\Job\JobParameters\ConstraintCollectionProviderInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Locale;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

/**
 * @author  Amir El Sayed <elsayed@basecom.de>
 *
 * Class ShopwareExport
 * @package Basecom\Bundle\ShopwareConnectorBundle\Job\JobParameters\ConstraintCollectionProvider
 */
class ShopwareExport implements ConstraintCollectionProviderInterface
{
    protected $supportedJobNames;

    /**
     * ShopwareExport constructor.
     *
     * @param $supportedJobNames
     */
    public function __construct($supportedJobNames)
    {
        $this->supportedJobNames = $supportedJobNames;
    }

    /**
     * @return Collection
     */
    public function getConstraintCollection()
    {
        return new Collection([
            'fields' => [
                'rootCategory' => [
                    new NotBlank(['groups' => 'Execution']),
                ],
                'apiKey'       => [
                    new NotBlank(['groups' => 'Execution']),
                ],
                'userName'     => [
                    new NotBlank(['groups' => 'Execution']),
                ],
                'url'          => [
                    new NotBlank(['groups' => 'Execution']),
                    new Url(['groups' => 'Execution']),
                ],
                'shop'         => [
                    new NotBlank(['groups' => 'Execution']),
                ],
                'locale'       => [
                    new NotBlank(['groups' => 'Execution']),
                ],
            ],
        ]);
    }

    /**
     * @param JobInterface $job
     *
     * @return bool
     */
    public function supports(JobInterface $job)
    {
        return in_array($job->getName(), $this->supportedJobNames);
    }
}
