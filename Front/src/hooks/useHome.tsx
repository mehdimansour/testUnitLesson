import { useEffect, useState } from "react";
import { endpoint, ProductModel } from "../App";

const useHome = () => {
  const [loading, setLoading] = useState<boolean>(true);
  const [products, setProducts] = useState<ProductModel[]>([]);

  const loadProducts = () => {
    return new Promise((resolve) =>
      fetch(`${endpoint}/products`)
        .then((res) => res.json())
        .then((res) => {
          setLoading(false);
          setProducts(res);
          resolve(true);
        })
    );
  };

  useEffect(() => {
    loadProducts();
  }, []);

  return {
    loading,
    products,
    loadProducts,
  };
};

export default useHome;
