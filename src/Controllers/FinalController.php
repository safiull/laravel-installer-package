<?php

namespace Safiull\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Safiull\LaravelInstaller\Events\LaravelInstallerFinished;
use Safiull\LaravelInstaller\Helpers\EnvironmentManager;
use Safiull\LaravelInstaller\Helpers\FinalInstallManager;
use Safiull\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Safiull\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Safiull\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Safiull\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
