using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class HauspaketAttributWert : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into hauspaket_attribut_wert (wert_id,attribut_id,wert_text,wert_ordnung,archived) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            query = AddParam(query, row, 3, DataType.NUMERIC, false);
            query = AddParamPlain(query, "n", DataType.STRING, true);

            return query;
        }
    }
}
