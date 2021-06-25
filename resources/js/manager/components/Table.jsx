import React from "react";
import { Link } from 'react-router-dom';

import TableBody from "./TableBody";
import TableHead from "./TableHead";
import Spinner from "./Spinner";

class Table extends React.Component
{
    constructor(props) 
    {
        super(props);
        this.state = {
            tableBodyItems: [],
            tableHeadItems: [],
            isRendered: false,
        };
    }

    componentDidMount()
    {
        let url = "/manager/" + this.props.model;
        let params = {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector("meta[name=csrf-token]").content
            },
            body: "",
        };

        fetch( url, params )
            .then(response => response.json())
            .then(data => {
                this.setState({
                    tableBodyItems: this.prepareTableBody(data),
                    tableHeadItems: this.prepareTableHead(data),
                    isRendered: true
                });
            })
            .catch(error => console.error("We've got an error on the board!", error));
    }

    prepareTableHead( $data )
    {
        let { attrnames } = $data;
        return attrnames;
    }

    prepareTableBody( $data )
    {
        let { items } = $data;
        return items;
    }

    renderTable()
    {
        return (
            <div className="table-responsive">
                <table className="table table-hover text-nowrap mb-5">

                    <TableHead items={ this.state.tableHeadItems } />

                    <TableBody 
                        items={ this.state.tableBodyItems } 
                        model={ this.props.model } />

                </table>
            </div>
        );
    }

    /*
     * The main method of the object
    */
    render() 
    {
        const { isRendered } = this.state;
        const linkTo = "/manager/" + this.props.model + "/create";

        return (
            <div className="card">
                <div className="card-body">
                    <Link 
                        to={ linkTo } 
                        className="btn btn-sm btn-primary mb-2" 
                        title="Add an user"
                    >
                        Create
                    </Link>

                    { isRendered ? this.renderTable() : <Spinner /> }

                </div>
            </div>
        );
    }
}

export default Table;