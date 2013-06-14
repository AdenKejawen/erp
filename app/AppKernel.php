<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new GatotKaca\Erp\UtilitiesBundle\GatotKacaErpUtilitiesBundle(),
            new GatotKaca\Erp\FinancialBundle\GatotKacaErpFinancialBundle(),
            new GatotKaca\Erp\HumanResourcesBundle\GatotKacaErpHumanResourcesBundle(),
            new GatotKaca\Erp\ProcurementBundle\GatotKacaErpProcurementBundle(),
            new GatotKaca\Erp\ProjectManagementBundle\GatotKacaErpProjectManagementBundle(),
            new GatotKaca\Erp\SalesBundle\GatotKacaErpSalesBundle(),
            new GatotKaca\Erp\WarehouseBundle\GatotKacaErpWarehouseBundle(),
            new GatotKaca\Erp\MainBundle\GatotKacaErpMainBundle(),
            new GatotKaca\Erp\MaterialRequirementBundle\GatotKacaErpMaterialRequirementBundle(),
            new GatotKaca\SetupBundle\GatotKacaSetupBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
