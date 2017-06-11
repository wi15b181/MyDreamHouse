using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class HauspaketAttribut : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into hauspaket_attribut (attribut_id,attribut_typ,attribut_typ_anzeige) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, true);

            return query;
        }
    }
}
