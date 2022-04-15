// cy1.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test
/// <reference types="cypress" />

describe("Rick Sanchez Cypress Test", () => {

    beforeEach(() => {
        // cy.visit();
        cy.visit(Cypress.env("host")+ ":" + Cypress.env("port") );
    })

    it("Test Products", () => {
      
      cy.get("img").should("have.length",20);
    });

    it("Test Selected One Product", ()=>{
        
        cy.get("img").first().click();
        cy.get("img").should("have.length",1);
        cy.get("input").should("have.length",1);
    });

    it("Test Select One Product and Add Quantity", ()=>{
        
        cy.get("img").first().click();
        cy.get("input").type("5");
        cy.get("button").click();
        cy.contains("Retour").click();
    });

    it("Test Cart Has the Selected Entity",()=>{
        
        cy.contains("Aller sur panier").click();
        cy.get("img").should("have.length.at.least",1);
        cy.get("input").should("have.length",0);
        cy.get("button").should("have.text","Supprimer du panier");

    });

    it("Test Delete Element From Cart",()=> {
        
        cy.contains("Aller sur panier").click();
        cy.get("button").click();

        cy.contains("Produit bien supprimé").should("be.visible");
        cy.contains("Retour").click();
    });
})