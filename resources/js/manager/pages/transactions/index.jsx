import React from "react";
import { Link, Route, Switch } from "react-router-dom";

import Form from "../../components/forms/CommonForm";
import Table from "../../components/Table";
import NoMatch from "../errors/404";

class Transactions extends React.Component
{
    getFormFields()
    {
        return [
            { // ID
                wrapperElement: {
                    className: "mb-2",
                },
                spanElement: {
                    className: "text-secondary"
                },
                inputElement: {
                    name: "id",
                    type: "hidden"
                },
            }, {
                wrapperElement: {
                    className: "mb-3",
                },
                labelElement: {
                    htmlFor: "first-name",
                    className: "form-label",
                    text:  "First Name"
                },
                inputElement: {
                    id: "first-name",
                    name: "first_name", 
                    type: "text",
                    className: "form-control",  
                    placeholder: "Type a first name..."
                },
                value: ""
            }, {
                wrapperElement: {
                    className: "mb-3",
                },
                labelElement: {
                    htmlFor: "last-name",
                    className: "form-label",
                    text:  "Last Name"
                },
                inputElement: {
                    id: "last-name",
                    name: "last_name", 
                    type: "text",
                    className: "form-control", 
                    placeholder: "Type a last name..."
                },
                value: ""
            }, {
                wrapperElement: {
                    className: "mb-3",
                },
                labelElement: {
                    htmlFor: "email",
                    className: "form-label",
                    text:  "Email"
                },
                inputElement: {
                    id: "email",
                    name: "email", 
                    type: "email",
                    className: "form-control",  
                    placeholder: "Type an email..."
                },
                value: ""
            }, {
                wrapperElement: {
                    className: "mb-3",
                },
                labelElement: {
                    htmlFor: "password",
                    className: "form-label",
                    text:  "Password"
                },
                inputElement: {
                    id: "password",
                    name: "password", 
                    type: "password",
                    className: "form-control",  
                    placeholder: "Set a password..."
                },
                value: ""
            }, {
                wrapperElement: {
                    className: "form-check form-switch my-4",
                },
                labelElement: {
                    htmlFor: "status",
                    className: "form-check-label",
                    text:  "Does the user has the approved email?"
                },
                inputElement: {
                    id: "status",
                    name: "status", 
                    type: "checkbox",
                    className: "form-check-input"
                },
                beginLayoutWith: "input",
                value: "Pending"
            },
        ];
    }

    /*
     * The main method of the object
    */
    render()
    {
        return (
            <>
            <section className="content-header">
                <div className="container-fluid">
                    <div className="row mb-2">
                        <div className="col-sm-6">
                            <h1>Transactions</h1>
                        </div>
                        <div className="col-sm-6">
                            <nav aria-label="breadcrumb">
                                <ol className="breadcrumb float-md-end">
                                    <li className="breadcrumb-item">
                                        <Link to="/manager/dashboard">
                                            Dashboard
                                        </Link>
                                    </li>
                                    <li className="breadcrumb-item active" aria-current="page">Transactions</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
            <section className="content">
                <div className="container-fluid">
                    Transactions
                    {/* <Switch>
                        <Route exact path="/manager/transactions/create">
                            <Form
                                model="transactions" 
                                url="create"
                                fields={ this.getFormFields() }
                                currentText="Create a transaction" />
                        </Route>
                        <Route exact path="/manager/transactions/edit/:id">
                            <Form
                                model="transactions" 
                                url="update"
                                fields={ this.getFormFields() }
                                currentText="Edit the transaction" />
                        </Route>
                        <Route exact path="/manager/transactions">
                            <Table model="transactions" />
                        </Route>
                        <Route path="*">
                            <NoMatch />
                        </Route>
                    </Switch> */}
                </div>
            </section>
            </>
        );
    }
}

export default Transactions;