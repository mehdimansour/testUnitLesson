import ReactDOM from "react-dom";
import { screen } from '@testing-library/react';
import Product from "../../components/Product";
import Cart from "../../components/Cart";
import Home from "../../components/Home";

let container: any;


beforeEach(() => {
  container = document.createElement("div");
  document.body.appendChild(container);
});


test('component Product', async () => {
      ReactDOM.render(<Product setRoute={() => {}} data={{
          image: "",
          name: "Rick",
          quantity: 10
      }} />, container);

    screen.getByText(/Figurine de Rick/i);
 });

test('component Cart', async () => {
    ReactDOM.render(<Cart setRoute={() => {}} />, container);
    screen.getByText(/Figurine/i);
    screen.getByText(/Quantitée/i);
});

test('component Home', async () => {
    ReactDOM.render(<Home setRoute={() => {}} />, container);
    screen.getByText(/Figurine/i);
    screen.getByText(/Aller sur panier/i);
});