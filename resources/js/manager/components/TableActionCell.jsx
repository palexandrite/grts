import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function TableActionCell( props )
{
    return (
        <th>
            <div className="btn-group">
                <span
                    className="btn btn-light btn-sm dropdown-toggle"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                    aria-expanded="false">

                    <FontAwesomeIcon 
                        icon={ ["fas", "ellipsis-h"] } 
                        size="1x" />
                    
                </span>
                <ul className="dropdown-menu dropdown-menu-lg-end">
                    <li>
                        <Link 
                            to={ "/manager/" + props.model + "/edit/" + props.id }
                            className="dropdown-item"
                        >
                            Edit
                        </Link>
                    </li>
                </ul>
            </div>
        </th>
    );
}

export default TableActionCell;