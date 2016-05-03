<?php

namespace Basecom\Bundle\ShopwareConnectorBundle\Reader;

use Akeneo\Component\Batch\Item\AbstractConfigurableStepElement;
use Akeneo\Component\Batch\Item\ItemReaderInterface;
use Akeneo\Component\Batch\Model\StepExecution;
use Akeneo\Component\Batch\Step\StepExecutionAwareInterface;
use Akeneo\Component\Classification\Repository\CategoryRepositoryInterface;
use Basecom\Bundle\ShopwareConnectorBundle\Entity\Category;
use Pim\Bundle\CatalogBundle\Manager\ChannelManager;
use Pim\Bundle\CatalogBundle\Repository\ProductRepositoryInterface;
use Pim\Component\Catalog\Model\Product;

/**
 * Fetches all products for a category and hands them over to the processor
 *
 * Class ShopwareProductExportReader
 * @package Basecom\Bundle\ShopwareConnectorBundle\Reader
 */
class ShopwareProductExportReader extends AbstractConfigurableStepElement implements
    ItemReaderInterface,
    StepExecutionAwareInterface
{
    /** @var StepExecution */
    protected $stepExecution;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var \ArrayIterator */
    protected $results;

    /** @var ChannelManager */
    protected $channelManager;

    /** @var string */
    protected $channel;

    /** @var string */
    protected $rootCategory;

    /**
     * ShopwareProductExportReader constructor.
     *
     * @param ProductRepositoryInterface  $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ChannelManager              $channelManager
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        ChannelManager $channelManager
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->channelManager = $channelManager;
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        if (null === $this->results) {
            $this->results = $this->getResults();
        }

        if (null !== $result = $this->results->current()) {
            $this->results->next();
            $this->stepExecution->incrementSummaryInfo('read');
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setStepExecution(StepExecution $stepExecution)
    {
        $this->stepExecution = $stepExecution;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFields()
    {
        return [
            'rootCategory' => [
                'options' => [
                    'label' => 'basecom_shopware_connector.export.rootCategory.label',
                    'help'  => 'basecom_shopware_connector.export.rootCategory.help'
                ]
            ],
            'channel'      => [
                'type'    => 'choice',
                'options' => [
                    'choices'  => $this->channelManager->getChannelChoices(),
                    'required' => true,
                    'select2'  => true,
                    'label'    => 'basecom_shopware_connector.export.channel.label',
                    'help'     => 'basecom_shopware_connector.export.channel.label'
                ]
            ]
        ];
    }

    /**
     * @return \ArrayIterator
     */
    public function getResults()
    {
        /** @var Category $rootCategory */
        $rootCategory = $this->categoryRepository->findOneByIdentifier($this->rootCategory);
        $categories = $this->categoryRepository->findAll();
        $products = [];
        /** @var Category $category */
        foreach ($categories as $category) {
            if ($category->getRoot() === $rootCategory->getId()) {
                /** @var Product $product */
                foreach ($this->productRepository->findAll() as $product) {
                    if (in_array($category->getCode(), $product->getCategoryCodes())) {
                        array_push($products, $product);
                    }
                }
            }
        }

        return new \ArrayIterator($products);
    }

    /**
     * @return mixed
     */
    public function getRootCategory()
    {
        return $this->rootCategory;
    }

    /**
     * @param mixed $rootCategory
     */
    public function setRootCategory($rootCategory)
    {
        $this->rootCategory = $rootCategory;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param mixed $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }
}
