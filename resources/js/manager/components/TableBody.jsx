import React from "react";

import TableActionCell from "./TableActionCell";

class TableBody extends React.Component
{
    renderTableBodyRow( item ) 
    {
        let i = 0;
        let output = [];
        for (let prop in item) {
            if ( item.hasOwnProperty( prop ) ) {
                output.push(
                    <th key={ i++ }>
                        { item[prop] }
                    </th>
                );
            }
        }
        output.push(
            <TableActionCell 
                key={ i++ } 
                id={ item.id }
                model={ this.props.model } />
        );
        return output;
    }

    /**
     * The main action
     */
     render()
     {
        if (this.props.items) {
            let content = this.props.items.map((value, index) => {
                return (
                    <tr key={ index }>
                        { this.renderTableBodyRow(value) }
                    </tr>
                );
            });

            return (
                <tbody>
                    { content }
                </tbody>
            );
        }
     }
}

export default TableBody;