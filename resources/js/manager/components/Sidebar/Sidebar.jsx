import React from "react";
import { Link } from "react-router-dom";

import SidebarItem from "./SidebarItem";

const MENU_SECTIONS = {
    header: {
        logoPath: "/storage/img/laravel-icon.svg",
        title: "Dashbord", 
        href: "/manager/dashboard", 
        itemClass: "brand-link" 
    },
    items: [
        {
            title: "Users", 
            href: "", 
            itemClass: "nav-header",
            icon: [], 
            iconClass: "", 
            badge: {
                badgeClass: "",
            },
        },
        {
            title: "All users", 
            href: "/manager/users", 
            itemClass: "nav-link", 
            icon: ["fas", "users"], 
            iconClass: "nav-icon", 
            badge: {
                badgeClass: "right badge bg-purple",
            },
        },
        {
            title: "Tippers", 
            href: "/manager/tippers", 
            itemClass: "nav-link", 
            icon: ["fas", "users"], 
            iconClass: "nav-icon", 
            badge: {
                badgeClass: "right badge bg-purple",
            },
        },
        {
            title: "Recievers", 
            href: "/manager/recievers", 
            itemClass: "nav-link", 
            icon: ["fas", "users"], 
            iconClass: "nav-icon", 
            badge: {
                badgeClass: "right badge bg-purple",
            },
        },
    ],
};

class SideBar extends React.Component
{
    render() {
        return (
            <aside className="main-sidebar sidebar-dark-primary elevation-4">
                <Link to={ MENU_SECTIONS.header.href } className={ MENU_SECTIONS.header.itemClass }>
                    <img 
                        src={ MENU_SECTIONS.header.logoPath } 
                        alt="Dashboard Logo" 
                        className="brand-image img-circle elevation-3"
                    />
                    <span className="brand-text font-weight-light">
                        { MENU_SECTIONS.header.title }
                    </span>
                </Link>
                <div className="sidebar">
                    <nav className="mt-2">
                        <ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            {
                                MENU_SECTIONS.items.map((value, index) => (
                                    <SidebarItem 
                                        key={ index } 
                                        current={ value } />
                                ))
                            }
                        </ul>
                    </nav>
                </div>
            </aside>
        );
    }
}

export default SideBar;