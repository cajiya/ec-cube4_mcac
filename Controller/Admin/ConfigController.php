<?php

namespace Plugin\MailChimpAddContact\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\MailChimpAddContact\Form\Type\Admin\ConfigType;
use Plugin\MailChimpAddContact\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/mail_chimp_add_contact/config", name="mail_chimp_add_contact_admin_config")
     * @Template("@MailChimpAddContact/admin/config.twig")
     */
    public function index(Request $request)
    {
        $Config = $this->configRepository->get();
        $form = $this->createForm(ConfigType::class, $Config);
        $form->handleRequest($request);

        $lists = [];
        $mode = $request->query->get('mode',null);
        $Config = $form->getData();
        $server_prefix = $Config->getServerPrefix();
        $api_key = $Config->getApiKey();
        if( $mode !== null && $mode === "getlists" && $server_prefix && $api_key ){

            $ch = curl_init("https://{$server_prefix}.api.mailchimp.com/3.0/lists");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $api_key ]);
    
            $response = json_decode(curl_exec($ch));
            $lists = $response->lists;
            curl_close($ch);

        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($Config);
            $this->entityManager->flush();
            $this->addSuccess('登録しました。', 'admin');

            return $this->redirectToRoute('mail_chimp_add_contact_admin_config');
        }

        return [
            'form' => $form->createView(),
            'lists' => $lists
        ];
    }
}
