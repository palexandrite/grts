import React from "react";
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import TableBody from "./TableBody";
import TableHead from "./TableHead";
import Pagination from "./Pagination";
import Spinner from "./Spinner";
import Toast from "./Toast";

class Table extends React.Component
{
    constructor(props) 
    {
        super(props);
        this.state = {
            tableBodyItems: [],
            tableHeadItems: [],
            currentPage: null,
            lastPage: null,
            isRendered: false,
            isSearch: false,
            successMessage: null,
            errorMessage: null,
            isToastRendered: false,
        };

        this.handlePaginationClick = this.handlePaginationClick.bind(this);
        this.handleSearchInputChange = this.handleSearchInputChange.bind(this);
        this.handleClickOnDeleteButton = this.handleClickOnDeleteButton.bind(this);
        this.fetchUrl = "/manager/" + props.model;
        this.fetchParams = {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector("meta[name=csrf-token]").content
            }
        };
        this.toastRef = React.createRef();
    }

    componentDidMount()
    {
        fetch( this.fetchUrl, this.fetchParams )
            .then(response => response.json())
            .then(json => {
                this.setState({
                    tableBodyItems: this.prepareTableBody(json),
                    tableHeadItems: this.prepareTableHead(json),
                    currentPage: this.getCurrentPage(json),
                    lastPage: this.getLastPage(json),
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
        let { pagination: { data: items } } = $data;
        return items;
    }

    getCurrentPage( $data )
    {
        let { pagination: { current_page: current } } = $data;
        return current;
    }

    getLastPage( $data )
    {
        let { pagination: { last_page: last } } = $data;
        return last;
    }

    handlePaginationClick( e )
    {
        let nextPage = e.currentTarget.dataset.page;
        let params = Object.assign({}, this.fetchParams);
        params.body = JSON.stringify({page: nextPage});

        fetch( this.fetchUrl, params )
            .then(response => response.json())
            .then(json => {
                this.setState({
                    tableBodyItems: this.prepareTableBody(json),
                    currentPage: this.getCurrentPage(json),
                });
            })
            .catch(error => console.error("We've got an error on the board!", error));
    }

    handleSearchInputChange( e )
    {
        let value = e.target.value;
        let isEmpty = value === "";
        let url = this.fetchUrl + "/search";
        let params = Object.assign({}, this.fetchParams);
        params.body = JSON.stringify({search: value});

        fetch( url, params )
            .then(response => response.json())
            .then(data => {
                let dataState = {};
                dataState.tableBodyItems = data;
                if ( isEmpty ) {
                    dataState.isSearch = false;
                    dataState.currentPage = 1;
                } else {
                    dataState.isSearch = true;
                }

                this.setState( dataState );
            })
            .catch(error => console.error("We've got an error on the board!", error));
    }

    handleClickOnDeleteButton( e )
    {
        let url = this.fetchUrl + "/delete";
        let params = Object.assign({}, this.fetchParams);
        let currentPage = (() => {
            let amount = this.state.tableBodyItems.length;
            let current = this.state.currentPage;
            if ( amount > 1 ) {
                return current;
            } else if ( amount === 1 && current !== 1 ) {
                return ( current - 1 );
            }

            return current;
        })();

        params.body = JSON.stringify({
            id: e.target.dataset.id,
            page: currentPage
        });
        
        fetch( url, params )
            .then(response => response.json())
            .then(json => {
                if ( json.success ) {
                    this.setState({
                        successMessage: json.success,
                        tableBodyItems: this.prepareTableBody(json),
                        currentPage: this.getCurrentPage(json),
                        lastPage: this.getLastPage(json),
                    });

                    let toast = this.toastRef.current.querySelector(".toast");

                    setTimeout(() => {
                        toast.classList.add("show");
                    }, 1000);

                    setTimeout(() => {
                        toast.classList.remove("show");
                    }, 10000);
                    
                } else if ( json.error ) {
                    this.setState({errorMessage: data.error});
                }
            })
            .catch(error => console.error("We've got an error on the board!", error));
    }

    renderTable()
    {
        return (
            <>                
            <div className="table-responsive">
                <table className="table table-hover text-nowrap mb-4">

                    <TableHead items={ this.state.tableHeadItems } />

                    <TableBody 
                        items={ this.state.tableBodyItems } 
                        model={ this.props.model }
                        onDeleteClick={ this.handleClickOnDeleteButton } />

                </table>
            </div>
            {
                this.state.isSearch || (this.state.lastPage === 1) ? "" : (
                    <Pagination 
                        current={ this.state.currentPage } 
                        last={ this.state.lastPage }
                        onClick={ this.handlePaginationClick } />
                )
            }
            </>
        );
    }

    /*
     * The main method of the object
    */
    render() 
    {
        const { errorMessage, successMessage, isRendered } = this.state;
        const linkTo = "/manager/" + this.props.model + "/create";

        let fontAwesome = false,
            message = false,
            cssClass = false;

        if ( successMessage !== null ) {
            message = successMessage;
            cssClass = "bg-info bg-gradient text-dark";
            fontAwesome = <FontAwesomeIcon icon={ ["fas", "check"] } size="1x" />;
        } else if ( errorMessage !== null ) {
            message = errorMessage;
            cssClass = "bg-danger bg-gradient text-dark";
            fontAwesome = <FontAwesomeIcon icon={ ["far", "times-circle"] } size="1x" />;
        }

        return (
            <div className="card">
                <div className="card-body">

                    {
                        !fontAwesome && !message ? "" : (
                            <Toast 
                                ref={ this.toastRef }
                                bodyStyle={ cssClass }
                                faAwesome={ fontAwesome }
                                message={ message } />
                        )
                    }

                    <div className="d-flex flex-column flex-sm-row">
                        <div className="col-3">
                            <Link 
                                to={ linkTo } 
                                className="btn btn-sm btn-primary mb-2" 
                                title="Add an user"
                            >
                                Create
                            </Link>
                        </div>

                        <div className="col-9">
                            <input 
                                type="search"
                                className="form-control form-control-sm border-start"
                                placeholder="Type and find what you looking for..."
                                onChange={ this.handleSearchInputChange } />
                        </div>
                    </div>

                    { isRendered ? this.renderTable() : <Spinner /> }

                </div>
            </div>
        );
    }
}

export default Table;