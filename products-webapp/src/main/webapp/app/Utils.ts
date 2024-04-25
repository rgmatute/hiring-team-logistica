import moment from "moment";

export const buildPaginationQueryOptsUtils = (paginationQuery) => {
    if (paginationQuery) {
      let sorts = '';
      for (const idx of Object.keys(paginationQuery.sort)) {
        if (sorts.length > 0) {
          sorts += '&';
        }
        sorts += 'sort=' + paginationQuery.sort[idx];
      }
      return `${sorts}&page=${paginationQuery.page}&size=${paginationQuery.size}&key=${paginationQuery.key}&value=${paginationQuery.value??''}`;
    }
    return '';
  }

export const formatDate = (dateString: string, format: string) => {
  return moment(dateString).format(format);
}

export const obtenerCambios = (jsonA: any, jsonB: any) => {
  const cambios = {};

  // Comparar cada atributo de jsonA con jsonB
  for (const key in jsonA) {
      if (jsonA.hasOwnProperty(key) && jsonB.hasOwnProperty(key)) {
          // Si los valores son diferentes, agregar al objeto de cambios
          if (jsonA[key] !== jsonB[key]) {
              cambios[key] = jsonB[key];
          }
      }
  }

  return cambios;
}
