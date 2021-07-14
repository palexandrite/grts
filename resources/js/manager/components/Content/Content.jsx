import React from "react";

import { Route, Switch, Redirect } from 'react-router-dom';

import Customers from "../../pages/customers";
import Home from "../../pages/home";
import Organizations from "../../pages/organizations";
import ServiceProviders from "../../pages/service-providers";
import Transactions from "../../pages/transactions";
import UserPage from "../../pages/users";
import NoMatch from "../../pages/errors/404";

class Content extends React.Component
{
    render() {
        return (
            <div className="content-wrapper">
                <Switch>
                    <Route path="/manager/customers">
                        <Customers />
                    </Route>
                    <Route path="/manager/organizations">
                        <Organizations />
                    </Route>
                    <Route path="/manager/service-providers">
                        <ServiceProviders />
                    </Route>
                    <Route path="/manager/transactions">
                        <Transactions />
                    </Route>
                    <Route path="/manager/users">
                        <UserPage />
                    </Route>
                    {/* <Route path="/manager/policies">
                        <PolicyPage />
                    </Route> */}
                    <Route exact path="/manager/dashboard">
                        <Home />
                    </Route>
                    <Route path="*">
                        <NoMatch />
                    </Route>
                </Switch>
            </div>
        );
    }
}

export default Content;