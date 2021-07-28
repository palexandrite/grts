import React from "react";

import { Route, Switch, Redirect } from 'react-router-dom';

import Tippers from "../../pages/tippers";
import Home from "../../pages/home";
import Organizations from "../../pages/organizations";
import Receivers from "../../pages/receivers";
import Transactions from "../../pages/transactions";
import UserPage from "../../pages/users";
import MailPage from "../../pages/mails";
import PushNotificationPage from "../../pages/push-notifications";
import NoMatch from "../../pages/errors/404";

class Content extends React.Component
{
    render() {
        return (
            <div className="content-wrapper">
                <Switch>
                    <Route path="/manager/tippers">
                        <Tippers />
                    </Route>
                    <Route path="/manager/organizations">
                        <Organizations />
                    </Route>
                    <Route path="/manager/receivers">
                        <Receivers />
                    </Route>
                    <Route path="/manager/transactions">
                        <Transactions />
                    </Route>
                    <Route path="/manager/users">
                        <UserPage />
                    </Route>
                    <Route path="/manager/mails">
                        <MailPage />
                    </Route>
                    <Route path="/manager/push-notifications">
                        <PushNotificationPage />
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