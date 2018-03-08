<?php

namespace CT\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CT\CoreBundle\Entity\Location;
use CT\CoreBundle\Entity\Department;
use CT\CoreBundle\Entity\Shift;
use CT\CoreBundle\Entity\Application;
use CT\CoreBundle\Entity\PlexPackage;
use CT\CoreBundle\Entity\paymentTransaction;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{
    public function indexAction()
    {

        /*$json = file_get_contents("department_guerro.json");
        $parsed_json = json_decode($json);
        $em = $this->getDoctrine()->getManager();
        $dep = $em->getRepository('CTCoreBundle:Department')->findAll();

        foreach($parsed_json as $shi)
        {
            $shift = new Shift();
            $shift->setDesiredCoverage($shi->{'desired_coverage'});


            $startDate = new \DateTime($shi->{'starts_at'});
            $endDate = new \DateTime($shi->{'ends_at'});
           // $shift->setStartsAt($startDate->add(new \DateInterval('P7D')));
            //$shift->setEndsAt($endDate->add(new \DateInterval('P7D')));
            $shift->setStartsAt($startDate);
            $shift->setEndsAt($endDate);
            $shift->setPrice(2);
            $shift->setPromotion(50);
            foreach ($dep as $de)
            {

                if($shi->{'department_id'} == $de->getStaffomaticId())
                {
                    $shift->setDepartment($de);
                    break;
                }
            }
            $em->persist($shift);
        }

        $em->flush();*/

        $em = $this->getDoctrine()->getManager();
        $app = $em->getRepository('CTCoreBundle:Application')->array_findAllWithShiftByDepartmentId(92213);

        for($i = 0; $i < count($app) ; $i++)
        {

            $startDate = $app[$i]["shift"]["startsAt"];
            $endDate = $app[$i]["shift"]["endsAt"];

            $app[$i]["shift"]["startsAt"] = $startDate->format('Y-m-d'). "T". $startDate->format('H:i:s')."+02:00";
            $app[$i]["shift"]["endsAt"] = $endDate->format('Y-m-d'). "T". $endDate->format('H:i:s')."+02:00";
        }


        return new Response(json_encode($app));
        //return $this->render('CTCoreBundle:Core:index.html.twig');
    }


    public function shiftsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $shifsManager = $this->container->get('ct_core.shift_manager');

        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('CTCoreBundle:Location')->array_findAll();
        $departments = $em->getRepository('CTCoreBundle:Department')->array_findAll();

        $keyLocation = "locationsSelect";
        $keyDepartment = "departmentsSelect";
        $keyDate = "date";
        $keyWeek = "week";

        if ($request->request->has($keyLocation) && $request->request->has($keyDepartment) && $request->request->has($keyDate) && $request->request->has($keyWeek)) {

            //DATE
            $dateSelected = $request->request->get($keyDate);
            $expTemp = $dateSelected;
            $dateTemp = explode('/', $expTemp);
            $exTemp = mktime(0, 0, 0, $dateTemp[0], 1, $dateTemp[1]);
            $actualYear = date('Y',$exTemp);
            $actualMonth = date('M',$exTemp);
            $previousDate = (new \DateTime(date('Y-m-d H:i:s',$exTemp)))->sub(new \DateInterval('P1M'));
            $nextDate = (new \DateTime(date('Y-m-d H:i:s',$exTemp)))->add(new \DateInterval('P1M'));
            $weeks = $shifsManager->getAllWeeksFromMonth($request->request->get($keyDate) );

            //SHIFTS
            $selectedWeekIndex = (int)$request->request->get($keyWeek);
            if($selectedWeekIndex == -1 && date("M") == $actualMonth)
            {
                for($i = 0; $i < count($weeks); $i++)
                {
                    foreach($weeks[$i] as $day)
                    {
                        if($day->format('d') == date('d'))
                        {
                            $selectedWeekIndex = $i;
                            break;
                        }
                    }
                }

            }
            else if($selectedWeekIndex == -1)
            {
                $selectedWeekIndex = 0;
            }
            $selectedDepartments =  $request->request->get($keyDepartment);

            $allOrganizedShifts = array();
            $endDate =  $weeks[$selectedWeekIndex][count($weeks[$selectedWeekIndex]) - 1]->add(new \DateInterval('PT23H59M'));
            foreach ($selectedDepartments as $dep)
            {
                $allOrganizedShifts[] = $shifsManager->getOrganizedShiftsByDepartment($weeks[$selectedWeekIndex][0],$endDate, $dep  , $weeks, $selectedWeekIndex);
            }

            dump($allOrganizedShifts);
            return $this->render('CTCoreBundle:Core:shifts.html.twig', array(

                'isSearching' => true,
                'locations' => $locations,
                'departments' => $departments,
                'postParameterLocation' => $request->request->get($keyLocation),
                'postParameterDepartments' => $request->request->get($keyDepartment),
                'postParameterDate' => $request->request->get($keyDate),
                'postParameterWeek' => $selectedWeekIndex,
                'actualYear' =>$actualYear,
                'actualMonth' => $actualMonth,
                'nextDate' => $nextDate->format("m/Y"),
                'previousDate' => $previousDate->format("m/Y"),
                'weeks' => $weeks,
                'allOrganizedShifts' => $allOrganizedShifts));
        }

        $selectedWeekIndex = -1;
        return $this->render('CTCoreBundle:Core:shifts.html.twig', array(
            'isSearching' => false,
            'locations' => $locations,
            'departments' => $departments,
            'postParameterWeek' => $selectedWeekIndex,
            'allOrganizedShifts' => array()));

    }


    public function workerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $userApplicationsChecker = $em->getRepository('CTCoreBundle:Application')->findByUserAndApplicationId($user->getId(),1550);
        if(count($userApplicationsChecker) > 0)
        {

            $em->remove($userApplicationsChecker[0]);
            $em->flush();

            $response["status"] = 1;
            $response["message"] = "Shift removed from cart.";
        }
        else
        {$response["status"] = 2;
            $response["message"] = "Shift not found in the cart.";

        }

        return $this->render('CTCoreBundle:Core:worker.html.twig');
    }

    public function faqAction()
    {

        $em = $this->getDoctrine()->getManager();

        $newTransaction = $em->getRepository('CTCoreBundle:paymentTransaction')->findByPaypalTransactionId("52P77922XJ262545J");

        dump($newTransaction);
        return $this->render('CTCoreBundle:Core:faq.html.twig');
    }


    public function cartAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $appInCart = $em->getRepository('CTCoreBundle:Application')->findByUserAndState($user->getId(), "in_cart");

        $totalprice = 0;
        foreach ($appInCart as $app)
        {
            $shiftPrice = $app->getShift()->getPrice();
            $shiftPromotion = $app->getShift()->getPromotion();
            $appPrice = $shiftPrice - ($shiftPrice*$shiftPromotion/100);
            $totalprice = $totalprice + $appPrice;
        }
        dump($totalprice);

        return $this->render('CTCoreBundle:Core:cart.html.twig', array('appsInCart' => $appInCart, 'totalPrice' => $totalprice));
    }

    public function buyTokenAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();


        $packagePlex = $em->getRepository('CTCoreBundle:PlexPackage')->findAll();



        return $this->render('CTCoreBundle:Core:buy_tokens.html.twig', array('packagePlex' => $packagePlex));
    }



    public function checkoutAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->query->has("tx")) {

            dump($request);
            $transacId = $request->query->get("tx");

            return $this->render('CTCoreBundle:Core:checkout.html.twig', array('transactionId' => $transacId));

            /*$newTransaction = $em->getRepository('CTCoreBundle:paymentTransaction')->findByPaypalTransactionId($transacId);


            dump($newTransaction);

            if(count($newTransaction) > 0)
            {
                $selectedPackage = $em->getRepository('CTCoreBundle:PlexPackage')->findById($newTransaction[0]->getItemNumber());
                return $this->render('CTCoreBundle:Core:checkout.html.twig', array('newTransaction' => $newTransaction,'selectedPackage' => $selectedPackage[0]));

            }
            else
            {
                return $this->render('CTCoreBundle:Core:worker.html.twig');


            }*/

        }
        else
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();

            $selectedPackage = $em->getRepository('CTCoreBundle:PlexPackage')->findById($id);

            if(count($selectedPackage) > 0)
            {
                return $this->render('CTCoreBundle:Core:checkout.html.twig', array('selectedPackage' => $selectedPackage[0]));
            }

            return new Response("error");
        }


    }


    public function cartRemoveApplicationAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $removedApplication = $em->getRepository('CTCoreBundle:Application')->findById($id);

        if(count($removedApplication)> 0)
        {
            if($removedApplication[0]->getUser()->getId() == $user->getId())
            {
                $em->remove($removedApplication[0]);
                $em->flush();
            }
        }


        return $this->redirectToRoute('ct_core_cart');
    }



    public function topbarAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $appInCart = $em->getRepository('CTCoreBundle:Application')->findByUserAndState($user->getId(), "in_cart");
        $appInCartCount = count($appInCart);



        return $this->render('CTCoreBundle::topbar.html.twig', array('applicationsInCartCount' => $appInCartCount));
    }




    public function freeBuyAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();


        if($user->getUsername() == "guerro@hotmail.fr")
        {
            $userApplications = $em->getRepository('CTCoreBundle:Application')->findByUser($user);
            {
                foreach ($userApplications as $app)
                {
                    $app->setState("buyed");
                }
                $em->flush();
            }
            dump($userApplications);
        }
        return $this->render('CTCoreBundle:Core:index.html.twig');
    }

    public function addToCartAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $response = array();
        $response["status"] = -1;
        $response["message"] = "EMPTY";
        if ($request->request->has("shift_id") && $user != null) {

            $em = $this->getDoctrine()->getManager();

            $shiftId = (int)$request->request->get("shift_id");
            $selectedShift = $em->getRepository('CTCoreBundle:Shift')->findById($shiftId);
            if(count($selectedShift) > 0)
            {


                if($selectedShift[0]->getDesiredCoverage() > $selectedShift[0]->getBuyedApplicationsCount())
                {
                    $userApplicationsChecker = $em->getRepository('CTCoreBundle:Application')->findByUserAndApplicationId($user->getId(),$shiftId);
                    if(count($userApplicationsChecker) == 0)
                    {
                        $newApplication = new Application();
                        $newApplication->setUser($user);
                        $newApplication->setShift($selectedShift[0]);
                        $newApplication->setCreatedAt(new \DateTime());
                        $newApplication->setState("in_cart");
                        $em->persist($newApplication);
                        $em->flush();

                        $response["status"] = 1;
                        $response["message"] = "Shift added to cart.";
                    }
                    else
                    {$response["status"] = 4;
                        $response["message"] = "Already in the cart.";

                    }

                }
                else
                {
                    $response["status"] = 2;
                    $response["message"] = "No more place available.";
                }

            }
            else
            {
                $response["status"] = 3;
                $response["message"] = "No shift found.";
            }

        }
        else
        {
            $response["status"] = 0;
            $response["message"] = "Bad request.";
        }




        return new Response(json_encode($response));
    }



    public function removeFromCartAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $response = array();
        $response["status"] = -1;
        $response["message"] = "EMPTY";
        if ($request->request->has("shift_id") && $user != null) {

            $em = $this->getDoctrine()->getManager();

            $shiftId = (int)$request->request->get("shift_id");
            $selectedShift = $em->getRepository('CTCoreBundle:Shift')->findById($shiftId);
            if(count($selectedShift) > 0)
            {

                    $userApplicationsChecker = $em->getRepository('CTCoreBundle:Application')->findByUserAndApplicationId($user->getId(),$shiftId);
                    if(count($userApplicationsChecker) > 0)
                    {

                        $em->remove($userApplicationsChecker[0]);
                        $em->flush();

                        $response["status"] = 1;
                        $response["message"] = "Shift removed from cart.";
                    }
                    else
                    {$response["status"] = 2;
                        $response["message"] = "Shift not found in the cart.";

                    }

            }
            else
            {
                $response["status"] = 3;
                $response["message"] = "No shift found.";
            }

        }
        else
        {
            $response["status"] = 0;
            $response["message"] = "Bad request.";
        }



        return new Response(json_encode($response));
    }



    public function paypalIPNAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $package = new PlexPackage();
        $package->setPrice(150);
        $package->setPlex(150);
        $package->setImage("zeze");
        $package->setPromotion(150);
        $package->setPaypalButtonId(150);

        $em->persist($package);
        $em->flush();

        return new Response("yeah");

    }


}
