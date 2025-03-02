<?php

namespace Robot\Core\Repositories\Program;

use Robot\Core\Entity\Program\DateCollection;
use Robot\Core\Entity\Program\ProgramCollection;
use Robot\Core\Entity\Program\ProgramSectionsReqParams;
use Robot\Core\Entity\Program\ProgramListReqParam;
use Robot\Core\Entity\Program\TimeLineReqParams;

interface IProgramRepository
{
    /**
     * @param ProgramSectionsReqParams $entity
     * @return array
     */
    public function getActiveSectionIds(ProgramSectionsReqParams $entity): array;

    /**
     * @param TimeLineReqParams $entity
     * @return DateCollection
     */
    public function getTimeLine(TimeLineReqParams $entity): DateCollection;

    /**
     * @param ProgramListReqParam $entity
     * @return array
     */
    public function getProgram(ProgramListReqParam $entity): ProgramCollection;
}