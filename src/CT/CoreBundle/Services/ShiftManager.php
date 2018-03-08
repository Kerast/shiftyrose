<?php
// src/FM/CoreBundle/ActionManager/ActionManager.php

namespace CT\CoreBundle\Services;

class ShiftManager
{
    private $em;
    private $security;
    private $router;

    public function __construct($em, $security, $router)
    {
        $this->em    = $em;
        $this->security    = $security;
        $this->router    = $router;
    }


    public function getAllWeeksFromMonth($dateToTransorm)
    {
        $dateSelected = $dateToTransorm;
        $expTemp = $dateSelected;
        $dateTemp = explode('/', $expTemp);
        $exTemp = mktime(0, 0, 0, $dateTemp[0], 1, $dateTemp[1]);
        $actualYear = date('Y',$exTemp);
        $actualMonth = date('M',$exTemp);
        $previousDate = (new \DateTime(date('Y-m-d H:i:s',$exTemp)))->sub(new \DateInterval('P1M'));
        $nextDate = (new \DateTime(date('Y-m-d H:i:s',$exTemp)))->add(new \DateInterval('P1M'));

        $list=array();
        $realList=array();
        $month = (int) date('m',$exTemp);
        $year = (int) date('Y',$exTemp);

        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time)==$month)
                $list[]=date('Y-m-d-D', $time);
        }

        foreach($list as $date)
            $realList[] = \DateTime::createFromFormat("Y-m-d-D", $date);

        $count = 0;
        while($realList[0]->format("D") != "Mon" && $count <10)
        {
            $count = $count +1;
            $tempDate = \DateTime::createFromFormat("Y-m-d-D", $realList[0]->format("Y-m-d-D"));
            array_unshift($realList,$tempDate->sub(new \DateInterval('P1D')));
        }

        while($realList[count($realList) -1]->format("D") != "Sun" && $count <10)
        {
            $count = $count +1;
            $tempDate = \DateTime::createFromFormat("Y-m-d-D", $realList[count($realList) -1]->format("Y-m-d-D"));
            array_push($realList, $tempDate->add(new \DateInterval('P1D')));
        }

        $arrayOfDays = array();
        $weeks = array();

        for($i=0; $i < count($realList); $i++)
        {
            if( $i%7 == 0 && $i > 0)
            {
                $weeks[] = $arrayOfDays;
                $arrayOfDays = array();
            }
            $realList[$i]->setTime(0,0,0);
            $arrayOfDays[] = $realList[$i];
        }
        $weeks[] = $arrayOfDays;
        return $weeks;
    }



    public function getOrganizedShiftsByDepartment($startDate, $endDate, $department_id, $weeks, $selectedWeekIndex)
    {
        $user = $this->security->getToken()->getUser();
        $shifts = $this->em->getRepository('CTCoreBundle:Shift')->findByRangeAndDepartment($startDate, $endDate, $department_id);
        $departmentEntity= $this->em->getRepository('CTCoreBundle:Department')->findById($department_id);

        $organizedShifts = array();


        for($i=0; $i < count($shifts); $i++)
        {
            $validAppCount = 0;
            $shifts[$i]["isFull"] = 0;
            foreach($shifts[$i]["applications"] as $app)
            {
                if($app["state"] == "buyed")
                    $validAppCount = $validAppCount +1;
            }
            $shifts[$i]["validApplicationsCount"] = $validAppCount;
            if($validAppCount == $shifts[$i]["desiredCoverage"])
            {
                $shifts[$i]["backgroundColor"] = "red";
                $shifts[$i]["isFull"] = 1;
            }
            else if($validAppCount == 0)
            {
                $shifts[$i]["backgroundColor"] = "green";
            }
            else
            {
                if(($validAppCount/$shifts[$i]["desiredCoverage"])*100 >= 50)
                {
                    $shifts[$i]["backgroundColor"] = "orange";
                }
                else
                {
                    $shifts[$i]["backgroundColor"] = "green";
                }
            }

            $shifts[$i]["isApplied"] = "none";
            foreach ($shifts[$i]["applications"] as $app)
            {
                if($app["user"]["id"] == $user->getId())
                {
                    $shifts[$i]["isApplied"] = $app["state"];
                    if($shifts[$i]["isApplied"] == "buyed")
                        $shifts[$i]["backgroundColor"] = "white";

                    break;
                }
            }

        }


        $safeCount = 0;
        while(count($shifts) != 0 && $safeCount < 100)
        {
            dump(count($shifts));
            $newLine = array();
            for($i=0; $i < count($weeks[$selectedWeekIndex]); $i++)
            {
                $selectedShift = null;
                $removedShiftIndex = -1;
                foreach($shifts as $key=>$value)
                {
                    if($weeks[$selectedWeekIndex][$i]->format("d") == $value["startsAt"]->format("d"))
                    {
                        if($selectedShift != null)
                        {
                            if( $selectedShift["startsAt"]->format("H:i") > $value["startsAt"]->format("H:i"))
                            {

                                $selectedShift = $value;
                                $removedShiftIndex = $key;
                            }
                        }
                        else
                        {
                            $selectedShift = $value;
                            $removedShiftIndex = $key;
                        }
                    }
                }

                if($removedShiftIndex != -1)
                {
                    unset($shifts[$removedShiftIndex]);
                    $newLine[] = $selectedShift;
                }
                else
                {
                    $newLine[] = null;
                }
            }

            $organizedShifts[] = $newLine;
            $safeCount = $safeCount + 1;
        }
        $departmentShifts = array();
        $departmentShifts[] = $departmentEntity[0];
        $departmentShifts[] = $organizedShifts;
        return $departmentShifts;
    }
}