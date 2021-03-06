<?php

namespace Basecom\Bundle\ShopwareConnectorBundle\Processor;

use Akeneo\Component\Batch\Item\ItemProcessorInterface;
use Akeneo\Component\Batch\Model\StepExecution;
use Akeneo\Component\Batch\Step\StepExecutionAwareInterface;

/**
 * @author  Amir El Sayed <aes@basecom.de>
 *
 * Class SimpleItemProcessor
 * @package Basecom\Bundle\ShopwareConnectorBundle\Processor
 */
class SimpleItemProcessor implements ItemProcessorInterface, StepExecutionAwareInterface
{
    /** @var StepExecution */
    protected $stepExecution;

    /**
     * processes the category for the export
     *
     * @param mixed $item
     *
     * @return mixed
     */
    public function process($item)
    {
        return $item;
    }

    /**
     * @param StepExecution $stepExecution
     */
    public function setStepExecution(StepExecution $stepExecution)
    {
        $this->stepExecution = $stepExecution;
    }
}
