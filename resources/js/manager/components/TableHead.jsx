import React from "react";

class TableHead extends React.Component
{
    renderTableHead()
    {
        let output = [];

        if (
            Array.isArray( this.props.items ) &&
            this.props.items.length > 0
        ) {

            let i, item = null;

            this.props.items.map((value, index) => {
                item = (
                    <th key={ index }>
                        { value }
                    </th>
                );
                output.push(item);
                i++;
            });

            output.push(<th key={ i } width="20px"></th>);
        }

        return ( <tr>{ output }</tr> );
    }

    /**
     * The main action
     */
    render()
    {
        return (
            <thead>
                { this.renderTableHead() }
            </thead>
        );
    }
}

export default TableHead;