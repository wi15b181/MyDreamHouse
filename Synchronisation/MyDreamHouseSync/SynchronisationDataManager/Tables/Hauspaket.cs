using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class Hauspaket : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into hauspaket (hauspaket_id,hersteller_id,berater_id,bezeichnung,preis,grundflaeche,wohnflaeche,stockwerke,benutzer_id,archived) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);
            query = AddParam(query, row, 3, DataType.STRING, false);
            query = AddParam(query, row, 4, DataType.NUMERIC, false);
            query = AddParam(query, row, 5, DataType.NUMERIC, false);
            query = AddParam(query, row, 6, DataType.NUMERIC, false);
            query = AddParam(query, row, 7, DataType.NUMERIC, false);
            query = AddParam(query, row, 8, DataType.NUMERIC, false);
            query = AddParamPlain(query,"n", DataType.STRING, true);

            return query;
        }
    }
}
