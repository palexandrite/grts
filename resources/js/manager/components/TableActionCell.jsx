import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function TableActionCell( props )
{
    const editLink = "/manager/" + props.model + "/edit/" + props.id;

    return (
        <th>
            <span className="text-nowrap">
                <Link to="/manager" className="btn btn-outline-primary btn-sm me-2" title="you can see detailed information by click">

                    <FontAwesomeIcon icon={ ["far", "eye"] } size="1x" />

                </Link>
                <Link to={ editLink } className="btn btn-outline-secondary btn-sm me-2">

                    <FontAwesomeIcon 
                        icon={ ["fas", "pencil-alt"] } 
                        size="1x" />

                </Link>
                <button 
                    data-id={ props.id }
                    className="btn btn-outline-danger btn-sm" 
                    onClick={ props.onDeleteClick }>

                    <FontAwesomeIcon 
                        icon={ ["fas", "trash-alt"] } 
                        size="1x" />

                </button>
            </span>
        </th>
    );
}

export default TableActionCell;