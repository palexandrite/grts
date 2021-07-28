import React from "react";
import { Link, Route, Switch } from "react-router-dom";

import Form from "../../components/forms/OrgForm";
import Table from "../../components/Table";
import NoMatch from "../errors/404";

import FormFields from "./FormFields";

class Organizations extends React.Component
{
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
                            <h1>Organizations</h1>
                        </div>
                        <div className="col-sm-6">
                            <nav aria-label="breadcrumb">
                                <ol className="breadcrumb float-md-end">
                                    <li className="breadcrumb-item">
                                        <Link to="/manager/dashboard">
                                            Dashboard
                                        </Link>
                                    </li>
                                    <li className="breadcrumb-item active" aria-current="page">Organizations</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
            <section className="content">
                <div className="container-fluid">
                    <Switch>
                        <Route exact path="/manager/organizations/create">
                            <Form
                                model="organizations" 
                                url="create"
                                fields={ FormFields() }
                                currentText="Create a organization" />
                        </Route>
                        <Route exact path="/manager/organizations/edit/:id">
                            <Form
                                model="organizations" 
                                url="update"
                                fields={ FormFields() }
                                currentText="Edit the organization" />
                        </Route>
                        <Route exact path="/manager/organizations">
                            <Table model="organizations" />
                        </Route>
                        <Route path="*">
                            <NoMatch />
                        </Route>
                    </Switch>
                </div>
            </section>
            </>
        );
    }
}

export default Organizations;