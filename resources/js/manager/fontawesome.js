// import the library
import { library } from "@fortawesome/fontawesome-svg-core";

// import your icons
import { 
    faArrowLeft,
    faArrowRight,
    faBars,
    faChevronLeft,
    faCheck,
    faMoneyBillAlt,
    faPencilAlt,
    faSitemap,
    faTrashAlt,
    faPeopleArrows, 
    faUsersCog,
    faUserTie
} from "@fortawesome/free-solid-svg-icons";

import {
    faTimesCircle
} from "@fortawesome/free-regular-svg-icons";

export default function FontAwesomeRegister()
{
    library.add(
        faArrowLeft,
        faArrowRight,
        faBars,
        faChevronLeft,
        faCheck,
        faMoneyBillAlt,
        faPencilAlt,
        faPeopleArrows,
        faTrashAlt,
        faTimesCircle,
        faSitemap, 
        faUsersCog,
        faUserTie
    );
}